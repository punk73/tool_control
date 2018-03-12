<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Dingo\Api\Routing\Helpers;
use App\Part;
use App\Pck31;
use App\Supplier;
use DB;


class PartsController extends Controller
{
    //
    public function index(){
    	// return Part::all();

        /*$pck31 = Pck31::select(DB::raw('
            DISTINCT part_no, part_name
        '))->get();

        return $pck31;*/
        $supplier = Supplier::all();
        return $supplier[0]->id;

    }

    public function store(){
    	
    }

    public function update(){
    	
    }

    public function delete(){
    	
    }
}
