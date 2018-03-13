<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ToolPart;

class ToolPartController extends Controller
{
    //

    public function index(Request $request){
    	$toolPart = ToolPart::select(['tool_id', 'part_id']);
    	
    	$message = 'OK';

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
    	$toolPart = new ToolPart;
    	$toolPart->part_id = $request->part_id;
    	$toolPart->tool_id = $request->tool_id;
    	
    	try {
    		$toolPart->save();
    	} catch (Exception $e) {
    		$message = $e;
    	}

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
    		$toolPart->destroy();
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
