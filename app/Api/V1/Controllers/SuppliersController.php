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
    	$currentUser = UserSupp::select([
    		'SuppName',
    		'SuppCode'
    	])->get();


    	return [
    		'count' => count($currentUser),
    		'data' => $currentUser
    	];
    }
}
