<?php

namespace App\Api\V1\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use Dingo\Api\Routing\Helpers;
use App\Supplier;
use App\UserSupp;
use DB;


class SuppliersController extends Controller
{	
	use Helpers;
	
    public function index(Request $request){
        if (isset( $request->limit) && $request->limit != '' ) {
            $limit = $request->limit;
        }else{
            $limit = 25;
        }

        $message = "OK";
    	$supplier = Supplier::select([
    		'id', 'name', 'code'
    	]);

        if (isset($request->code)) {
            $supplier = $supplier->where('code', 'like', $request->code .'%' );
        }

        if (isset($request->name)) {
            $supplier = $supplier->where('name', 'like', $request->name .'%' );
        }        

        $supplier = $supplier->paginate($limit);

        $additional_message = collect(['_meta'=> [
            'message'=>$message,
            'count'=> count($supplier)
        ] ]);
        //adding additional message
        $supplier = $additional_message->merge($supplier);
        $supplier = $supplier->toArray();

        return $supplier;
    }

    public function show($id){
        $supplier = Supplier::find($id);
        if (!empty($supplier)) {
            $message = 'Ok';
            $supplier->parts;

        }else{
            $message = 'Data not found';
        }

        return [
            '_meta' =>[
                'message' => $message,
                'count' => count($supplier),
            ],
            'data' => $supplier,
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

    public function all(){
        $supplier = Supplier::all();
        $message = 'OK';

        return [
            '_meta' =>[
                'count' => count($supplier),
                'message' => $message
            ],
            'data'=>    $supplier
        ];
    }

    public function sync (){
        // truncate table supplier,
        /*DB::table('suppliers')->truncate();*/
        //reupload
        
        $currentUser = UserSupp::select([
            'SuppName',
            'SuppCode'
        ])->get();

        foreach ($currentUser as $key => $value){ 
            # code...
            $value['SuppName'] = str_replace("  ", "", $value['SuppName']);  

            $supplier = Supplier::where('name', '=', $value['SuppName'] )->where('code','=', $value['SuppCode'])->first();
            if ($supplier == null ){
                $supplier = new Supplier;
                $supplier->name = $value['SuppName'];
                $supplier->code = $value['SuppCode'];
                $supplier->save();   
            }
        }

        return [
            '_meta' => [
                'message' => 'OK'
            ],
            'data' => $currentUser
        ];
    }
    
}
