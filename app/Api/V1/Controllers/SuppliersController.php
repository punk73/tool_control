<?php

namespace App\Api\V1\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use Dingo\Api\Routing\Helpers;
use App\Supplier;
use App\UserSupp;


class SuppliersController extends Controller
{	
	use Helpers;
	
    public function index(Request $request){
    	$supplier = Supplier::select([
    		'id', 'name', 'code'
    	])->get();

    	return [
    		'count' => count($supplier),
    		'data' => $supplier
    	];
    }

    public function store(Request $request){
    	$supplier = new Supplier;
    	$supplier->name = $request->name;
    	$supplier->code = $request->code;

    	$supplier->save();

    	return [
    		'_meta' =>[
	    		'message' => 'OK',
	    		'count' => count($supplier),
	    	],
    		'data' => $supplier,
    	];

    }

    public function update(Request $request){
    	$supplier = Supplier::find($request->id);
    	$message = 'Data not found';

    	if (!empty( $supplier)) {
    		$supplier->name = $request->name;
	    	$supplier->code = $request->code;

	    	$supplier->save();
    		$message = 'OK';
    	}

    	return [
    		'_meta' =>[
	    		'message' => $message,
	    		'count' => count($supplier),
	    	],
    		'data' => $supplier,
    	];

    }

    public function delete(Request $request){
    	$supplier = Supplier::find($request->id);
    	$message = 'Data not found';
    	
    	if (!empty( $supplier)) {

	    	$supplier->delete();
    		$message = 'OK';
    	}

    	return [
    		'_meta' =>[
	    		'message' => $message,
	    		'count' => count($supplier),
	    	],
    		//'data' => $supplier,
    	];
    }

    
}
