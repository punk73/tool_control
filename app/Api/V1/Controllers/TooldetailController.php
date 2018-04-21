<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Tool_detail;
use App\Tool;


class ToolDetailController extends Controller
{
    public function index(Request $request)
    {
    	$tools = Tool_detail::has('tool');

    	if (isset($request->tool_id) && $request->tool_id != '' ) {
			$tools = $tools->where('tool_id', $request->tool_id );    		
    	}

		if (isset($request->tool_no) && $request->tool_no != '' ) {
			$tools = $tools->whereHas('tool', function($query) use ($request){
                $query->where( 'no', 'like', $request->tool_no . '%');
            });    		
    	}    	

    	$tools = $tools->paginate();

    	return $tools;

    }
}
