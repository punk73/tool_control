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
        // $part = $part->where('is_deleted', '=', 0)->get();
        
        if (!empty($part) && $part->is_deleted == 0 ) {
            // $part->supplier;
            $message = "OK";
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
        $part->total_delivery = $request->total_delivery;
        $part->total_qty = $request->total_qty;

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

            $part->total_delivery = (isset($request->total_delivery) ) ? $request->total_delivery : $part->total_delivery;
            $part->total_qty = (isset($request->total_qty) ) ? $request->total_qty : $part->total_qty; 

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
            $part->save();
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
