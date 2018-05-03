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
            'tool:id,no,name,supplier_id', 
            'part:id,no,name',
            'tool.supplier:id,name,code'
        ]);
    
    	$message = 'OK';

        //searching tool number first
        if ($request->tool_number && $request->tool_number !='' ) {
            $toolPart = $toolPart->whereHas('tool', function ($query) use ($request){
                $query->where('no', 'like', $request->tool_number . '%' );
            });
        }

        if ($request->part_number && $request->part_number != '' ) {
            $toolPart = $toolPart->whereHas('part', function($query) use($request){
                $query->where('no', 'like', $request->part_number  . '%');
            });
        }

        if ($request->supplier_name && $request->supplier_name != '' ) {
            $toolPart = $toolPart->whereHas('tool.supplier', function($query) use($request){
                $query->where('name', 'like', $request->supplier_name  . '%' );
            });
        }

        if ($request->cavity) {
            $toolPart = $toolPart->where('cavity', '=', $request->cavity );
        }

    	if ($request->tool_id) {
    		$toolPart = $toolPart->where('tool_id', '=', $request->tool_id );
    	}

		if ($request->part_id) {
    		$toolPart = $toolPart->where('part_id', '=', $request->part_id );
    	}    	

    	$toolPart = $toolPart->paginate();

        return $toolPart;

    	/*return [
    		'_meta' => [
    			'message' => $message,
    			'count' => count($toolPart)
    		],
    		'data' => $toolPart
    	];*/
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
            
            if ($request->cavity == 0 ) {
                $request->cavity = 1;
            }

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

    public function update (Request $request, $id){
        $toolpart = ToolPart::find($id);

        if (!empty($toolpart)) {

            $toolpart->is_independent = (isset($request->is_independent)) ? $request->is_independent : $toolpart->is_independent;
            
            if ($request->cavity == 0) {
                $request->cavity = 1;
            }

            $toolpart->cavity = (isset($request->cavity)) ? $request->cavity : $toolpart->cavity;

            $message = 'OK';

            try {
                $toolpart->save();        
            } catch (Exception $e) {
                $message = $e;
            }
        }

        return [
            '_meta' => [
                'message' => $message,
                'count' => count($toolpart)
            ],
            'data' => $toolpart
        ];
    }

}
