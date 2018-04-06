<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Forecast;
use DB;


class ForecastController extends Controller
{
    public function index(Request $request){

    	// $SuppCode = (isset($request->supp_code)) ? $request->supp_code : 10703 ;
    	$PartNo = (isset($request->part_no)) ? $request->part_no : 'RK73GB2A102J  9' ;
   		//ambil trans_date  	
    	$trans_date = Forecast::select(DB::raw('TransDate'))
    	->where('TransDate', '!=', 'EOF')
    	// ->where('SuppCode', '=', $SuppCode )
    	->where('PartNo', '=', $PartNo )
        // ->where('PartNo', 'like', $PartNo .'%' )

    	->orderByRaw('convert(datetime,TransDate) desc')
    	->first();
        
        if (is_null($trans_date)) {
            return '';    
        }

    	$trans_date = $trans_date->toArray();

    	$trans_date =  $trans_date['TransDate'];

    	$forecast = Forecast::select(DB::raw('
    		TransDate as trans_date,
    		RT,
    		SuppCode,
    		PartNo,
    		DTQTY30 as month1,
    		DTQTY31 as month2,
    		DTQTY32 as month3,
    		DTQTY33 as month4,
    		DTQTY34 as month5
    	'))->where('RT', '=', 'D' );

    	if (isset($request->trans_date)) {
    		$forecast = $forecast->where('TransDate','=', $request->trans_date);
    	}else{
    		$forecast = $forecast->where('TransDate','=', $trans_date);
    	}

		// $forecast = $forecast->where('PartNo','like', $PartNo . '%');
        $forecast = $forecast->where('PartNo','=', $PartNo);

    	$forecast = $forecast->get();

        $forecast->each(function($model){
            $model->total = ($model->month1+$model->month2+$model->month3+$model->month4+$model->month5);
        });

    	return $forecast;
    }
}
