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

    	$part = Part::where('is_deleted', 0);
        
        if (isset($request->no) && $request->no != "" ) {
            $part = $part->where('no', '=', $request->no );
        }

        $message = "OK";

        try {
            $part = $part->paginate();
        } catch (Exception $e) {
            $message = $e;
        }

        if ( !$part->isEmpty() ) {
            $part->each(function($model){
                $model->tools;
                $model->detail = $model->detail();
            });
        }        

        return $part;

        /*return [
            "_meta" => [
                "count" => count($part),
                "message" => $message
            ],
            "data" => $part
        ];*/
    }

    public function all(Request $request){
       $part = Part::select([
            'id',
            'no',
            'name',
       ])->where('is_deleted', 0);

       if ($request->get('query') !== null ) {
           $part = $part->where('no', 'like', $request->get('query')."%" );
       }

       if ($request->get('supplier_id') !== null ) {
           $part = $part->where('supplier_id', '=', $request->get('supplier_id') );
       }
         
       $message = "OK";

       try {
           $part = $part->get();
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

    public function show($id){
        $part = Part::find($id);

        
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
}
