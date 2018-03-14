<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tool_detail;

class TooldetailController extends Controller
{
    public function index(){
    	
    	$tool_detail = Tool_detail::all();
    	return $tool_detail;
    }

    public function store(Request $request){
    	$tool_detail = new Tool_detail;
    	$tool_detail->tool_id = $request->tool_id;
    	$tool_detail->machine_counter = $request->machine_counter;
    	$tool_detail->tanggal = $request->tanggal;
    	$tool_detail->note = $request->note;

    	$message = "OK";

    	try {
    		$tool_detail->save();
    	} catch (Exception $e) {
    		$message = $e;
    	}

    	return [
    		'_meta'=>[
    			'count' => count($tool_detail),
    			'message' => $message
    		],
    		'data' => $tool_detail
    	];

    }
}
