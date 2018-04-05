<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ToolPart;

class ToolPartController extends Controller
{
    //

    public function index(Request $request){
    	$toolPart = ToolPart::select();
    	
    	$message = 'OK';

    	if ($request->tool_id) {
    		$toolPart = $toolPart->where('tool_id', '=', $request->tool_id );
    	}

		if ($request->part_id) {
    		$toolPart = $toolPart->where('part_id', '=', $request->part_id );
    	}    	

    	$toolPart = $toolPart->get();

        if (!$toolPart->isEmpty() ) {
            $toolPart->each(function($model){
                $model->tools();
                $model->parts();
            });
        }

    	return [
    		'_meta' => [
    			'message' => $message,
    			'count' => count($toolPart)
    		],
    		'data' => $toolPart
    	];
    }

    public function store(Request $request){
    	
        $toolPart = new ToolPart;
    	$toolPart->part_id = $request->part_id;
    	$toolPart->tool_id = $request->tool_id;
        $toolPart->cavity = $request->cavity;

    	$message = 'OK';

    	try {
    		$toolPart->save();
    	} catch (Exception $e) {
    		$message = $e;
    	}
            
        $toolPart->tool = $toolPart->tool($toolPart->tool_id);
        $toolPart->part = $toolPart->part($toolPart->part_id);

    	return [
    		'_meta' => [
    			'message' => $message,
    			'count' => count($toolPart)
    		],
    		'data' => $toolPart
    	];
    }

    public function delete($id){
    	$toolPart = ToolPart::find($id);
    	if (!empty($toolPart)) {
    		$toolPart->delete();
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
