<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Dingo\Api\Routing\Helpers;
use App\Part;
use App\Pck31;
use App\Supplier;
use DB;


class PartsController extends Controller
{
    //
    public function index(Request $request){
        $limit = (isset($request->limit)) ? $request->limit : 15 ;

    	$part = Part::where('is_deleted', 0)->with([
            'details',
            'tools',
            'supplier'
        ]);
        
        if (isset($request->no) && $request->no != "" ) {
            $part = $part->where('no', 'like', $request->no . '%' );
        }

        if (isset($request->name) && $request->name != "" ) {
            $part = $part->where('name', 'like', $request->name . '%' );
        }

        if (isset($request->model) && $request->model != "" ) {
            $part = $part->where('model', 'like', $request->model . '%' );
        }

        if (isset($request->first_value) && $request->first_value != "" ) {
            $part = $part->where('first_value', 'like', $request->first_value . '%' );
        }

        if (isset($request->date_of_first_value) && $request->date_of_first_value != "" ) {
            $part = $part->where('date_of_first_value', 'like', $request->date_of_first_value . '%' );
        }

        if (isset($request->supplier_id) && $request->supplier_id != "" ) {
            $part = $part->where('supplier_id', '=', $request->supplier_id );
        }

        if (isset($request->supplier_name) && $request->supplier_name != "" ) {
            $part = $part->whereHas('supplier', function($query) use ($request){
                $query->where('name', 'like', $request->supplier_name . '%' );
            });
        }

        $message = "OK";

        try {
            $part = $part->orderBy('id', 'desc')->paginate($limit);
        } catch (Exception $e) {
            $message = $e;
        }

        return $part;
    }

    public function all(Request $request){
       $limit = (isset($request->limit)) ? $request->limit : 1000 ;
       $part = Part::select([
            'id',
            'no',
            'name',
       ])->where('is_deleted', 0);

       if ($request->get('query') !== null ) {
           $part = $part->where('no', 'like', $request->get('query')."%" );
       }

       if ($request->get('supplier_id') !== null && preg_match('/^\d+$/', $request->supplier_id ) ) {
           $part = $part->where('supplier_id', '=', $request->get('supplier_id') );
       }
         
       $message = "OK";

       try {
           // $part = $part->paginate($limit);
            $part = $part->orderBy('id', 'desc')->get();
       } catch (Exception $e) {
           $message = $e;
       }

       // return $part;

        return [
            "_meta" => [
                "count" => count($part),
                "message" => $message
            ],
            "data" => $part
        ];
    }

    public function show($id){
        $part = Part::with([
            'details',
            'tools',
            'supplier',
            'parentParts'
        ])->find($id);

        
        if (!empty($part) && $part->is_deleted == 0 ) {
            $message = "OK";
            $tools = Part::find($id)->tools;
            $part->tools = $tools;
        }else{
            $message = 'Data not found';
            $part = null;
        }

        return [
            "_meta" => [
                "count" => count($part),
                "message" => $message
            ],
            "data" => $part
        ];
    }

    public function store(Request $request){
    	$part = new Part;
        $part->no = $request->no;
        $part->name = $request->name;
        $part->supplier_id = $request->supplier_id;
        $part->model = $request->model;
        $part->first_value = $request->first_value;
        $part->date_of_first_value = $request->date_of_first_value;

        // $part->total_delivery = $request->total_delivery;
        // $part->total_qty = $request->total_qty;

        try {
            $part->save();
            $message = 'OK';
        } catch (Exception $e) {
            $message = $e;
        }

        return [
            "_meta" => [
                "count" => count($part),
                "message" => $message
            ],
            "data" => $part
        ];
    }

    public function update(Request $request, $id){
    	$part = Part::find($id);
        //jika ada dan part belum dihapus
        if ( !empty($part) && $part->is_deleted == 0 ) {
            // $retVal = (condition) ? a : b ;
            $part->no =  (isset($request->no) ) ? $request->no : $part->no;
            
            $part->name = (isset($request->name) ) ? $request->name : $part->name;

            $part->supplier_id = (isset($request->supplier_id) ) ? $request->supplier_id : $part->supplier_id;

            $part->model = (isset($request->model) ) ? $request->model : $part->model;
            
            $part->first_value = (isset($request->first_value) ) ? $request->first_value : $part->first_value;

            $part->date_of_first_value = (isset($request->date_of_first_value) ) ? $request->date_of_first_value : $part->date_of_first_value;


            try {
                $part->save();
                $message = 'OK';
            } catch (Exception $e) {
                $message = $e;
            }

        }else{ //jika tidak ada atau data sudah dihapus
            $message = "Data not found";
            $part = null;
        }

        return [
            "_meta" => [
                "count" => count($part),
                "message" => $message
            ],
            "data" => $part
        ];
    }

    public function delete(Request $request, $id){
    	$part = Part::find($id);
        if (!empty($part) ) {
            $part->is_deleted = 1;
            // $part->no = $part->no . " is deleted"; //biar bisa input 
            // $part->save();
            $part->delete(); //now im using laravel way to soft delete

            $message = "OK";
            // return $part->is_deleted;
        }else{
            $message = "Data not found";
        }

        return [
            "_meta" => [
                "count" => count($part),
                "message" => $message,
            ]
        ];
    }

    public function download(){
        $do = DB::table('parts');

        $do = $do->select([
            'parts.id',
            'no',
            'parts.name',
            // 'supplier_id',
            'suppliers.name as supplier_name',
            'model',
            'first_value',
            'date_of_first_value',
        ])->where('deleted_at', null)
        ->join('suppliers', 'parts.supplier_id', '=', 'suppliers.id')
        ->get();

        $fname = 'Parts.csv';

        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename=$fname");
        header("Pragma: no-cache");
        header("Expires: 0");
        
        $fp = fopen("php://output", "w");
        
        $headers = 'id,no,name,supplier_name,model,first_value,date_of_first_value'."\n";

        fwrite($fp,$headers);

        foreach ($do as $key => $value) {
            # code...
            $row = [
                $value->id,
                $value->no,
                $value->name,
                $value->supplier_name,
                $value->model,
                $value->first_value,
                $value->date_of_first_value,   
            ];
            
            fputcsv($fp, $row);
        }

        fclose($fp);
    }
}
