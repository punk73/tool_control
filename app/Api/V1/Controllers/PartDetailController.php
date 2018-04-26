<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Part_detail;
use App\Tool;


class PartDetailController extends Controller
{
    public function index(Request $request)
    {
    	$parts = Part_detail::has('part');

    	if (isset($request->part_id) && $request->part_id != '' ) {
			$parts = $parts->where('part_id', $request->part_id );    		
    	}

        if (isset($request->trans_date) && $request->trans_date != '' ) {
            $parts = $parts->where('trans_date', $request->trans_date );          
        }		  	

    	$parts = $parts
        ->orderBy('trans_date', 'desc')
        ->paginate();

    	return $parts;

    }
}
