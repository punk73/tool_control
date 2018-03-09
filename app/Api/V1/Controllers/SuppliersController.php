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

    public function getcsv(){
        $path = storage_path('app\data.csv');
        $file = fopen($path, "r");
        $array = array();
        while ( ($data = fgetcsv($file, 200, ",")) !==FALSE ) {

            /*$name = $data[0];
            $city = $data[1];
            $all_data = $name. " ".$city;*/

            array_push($array, $data[1]);

          }
        fclose($file);

        return $array;
    }
}
