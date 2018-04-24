<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ToolPart;
use App\Tool;
use App\Part;

class ToolPartController extends Controller
{
    //

    public function index(Request $request){
    	$toolPart = ToolPart::with([
            'tool' => function ($tool){
                $tool->select(['id','no', 'name']);
            }, 
            'part' => function ($part){
                $part->select(['id','no','name']);
            }
        ]);
    	
    	$message = 'OK';

        //searching tool number first
        if ($request->tool_number && $request->tool_number !='' ) {
            $tool = Tool::select(['id', 'no'])->where('no', 'like', $request->tool_number . '%' )->get();
            //jika tidak kosong baru filter
            if(!$tool->isEmpty()){
                $id = [];
                foreach ($tool as $key => $value) {
                    $id[] = $value['id'];        
                }

                $toolPart = $toolPart->whereIn('tool_id', $id );
            }

        }

        if ($request->part_number && $request->part_number != '' ) {
            $part = Part::select(['id', 'no'])->where('no', 'like', $request->part_number . '%' )->get();
            //jika tidak kosong baru filter
            if(!$part->isEmpty()){
                $id = [];
                foreach ($part as $key => $value) {
                    $id[] = $value['id'];        
                }

                $toolPart = $toolPart->whereIn('part_id', $id );
            }
        }

        if ($request->cavity) {
            $toolPart = $toolPart->where('cavity', '=', $request->cavity );
        }

        //        

    	if ($request->tool_id) {
    		$toolPart = $toolPart->where('tool_id', '=', $request->tool_id );
    	}

		if ($request->part_id) {
    		$toolPart = $toolPart->where('part_id', '=', $request->part_id );
    	}    	

    	$toolPart = $toolPart->get();

    	return [
    		'_meta' => [
    			'message' => $message,
    			'count' => count($toolPart)
    		],
    		'data' => $toolPart
    	];
    }

    public function store(Request $request){
    	
        /*$toolPart = new ToolPart;
    	$toolPart->part_id = $request->part_id;
    	$toolPart->tool_id = $request->tool_id;
        $toolPart->is_independent = $request->is_independent;
        $toolPart->cavity = $request->cavity;*/

        $tool = Tool::find($request->tool_id);
        
    	$message = 'OK';

    	try {
            $tool->parts()->attach($request->part_id , [
                'is_independent' => $request->is_independent,
                'cavity' => $request->cavity
            ]);

            $toolpart = ToolPart::with([
                'tool' => function($query){
                    $query->select([
                        'id',
                        'no'
                    ]);
                },

                'part' => function($query){
                    $query->select([
                        'id',
                        'no'
                    ]);
                },

            ])->where('tool_id', $tool->id )
            ->where('part_id', $request->part_id )
            ->first();

            if (!empty($toolpart)) {

                $tool = $toolpart;
            }

    	} catch (Exception $e) {
    		$message = $e;
    	}

    	return [
    		'_meta' => [
    			'message' => $message,
    			'count' => count($tool)
    		],
    		'data' => $tool
    	];
    }

    public function delete($id){


    	$toolPart = ToolPart::find($id);
    	
        if (!empty($toolPart)) {
    		$toolPart->forceDelete(); 

            //softdelete causing some problem with relation
    		/* so instead using delete() we using forceDelete to permanently delete toolpart instead of using soft delete*/
            $message = 'OK';
    	}else{
    		$message = 'Data not found';
    	}

    	return [
    		'_meta' => [
    			'message' => $message,
    			'count' => count($toolPart)
    		]
    	];

    }

}
