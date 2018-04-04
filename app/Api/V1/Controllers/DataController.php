<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use JWTAuth;
use Dingo\Api\Routing\Helpers;
use App\Part;
use App\Pck31;
use App\Supplier;
use App\ToolPart;
use App\Tool;
use App\Forcast;
use App\Api\V1\Controllers\ToolPartController;
use App\Api\V1\Controllers\Pck31Controller;
use App\Api\V1\Controllers\ForecastController;
use Carbon\Carbon;
use DB;

class DataController extends Controller
{
    //helper api
	use Helpers;


	public function pck31(Request $request){
		$pck31 = new Pck31Controller;
		// $request->part_no = '1SS355VM9';
		$pck31 = $pck31->index($request);
		return $pck31['data'][0];
	}

	public function forecast(Request $request){

		$forecast = new ForecastController;
		$forecast = $forecast->index($request);
		if ($forecast != '') {
			# code...
			return $forecast[0];
		}

	}

	public function index(Request $request){
		$toolpart = ToolPart::select();
		$message = 'OK';
		// $tgl = "04/03/2018";
		
		// return Carbon::createFromFormat('m/d/Y', $tgl )->format('Y-m-d');
		//setting part no
		if (isset($request->part_no) && $request->part_no != '' ) {
			$part_no = Part::select('id')->where('no', 'like', $request->part_no.'%' )->first();
			if ($part_no != null ) {
				$request->part_id = $part_no['id'];
			}
		}

		if (isset($request->part_name) && $request->part_name != '' ) {
			$part_name = Part::select('id')->where('name', 'like', $request->part_name.'%' )->first();
			if ($part_name != null ) {
				$request->part_id = $part_name['id'];
			}
		}

		//setting tool no
		if (isset($request->tool_no) && $request->tool_no != '' ) {
			$tool_no = Tool::select('id')->where('no', 'like', $request->tool_no.'%' )->first();
			if ($tool_no != null ) {
				$request->tool_id = $tool_no['id'];
			}
		}

		//setting tool name
		if (isset($request->tool_name) && $request->tool_name != '' ) {
			$tool_name = Tool::select('id')->where('name', 'like', $request->tool_name.'%' )->first();
			if ($tool_name != null ) {
				$request->part_id = $tool_name['id'];
			}
		}

		if (isset($request->part_id) && $request->part_id != '' ) {
			$toolpart = $toolpart->where('part_id', '=', $request->part_id );
		}

		if (isset($request->tool_id) && $request->tool_id != '' ) {
			$toolpart = $toolpart->where('tool_id', '=', $request->tool_id );
		}


		try {
			$toolpart = $toolpart->paginate();
		} catch (Exception $e) {
			$message = $e;
		}


		foreach ($toolpart as $key => $value) {

			$value->parts();

			$value->tools(null, $value['part']['no'] ); //parameter pertama tool id, ke dua part no
			
			$request->part_no = $value['part']['no'];
			$value['forecast'] = $this->forecast($request);
			
			//get total shoot 
			// $value['detail'] = 			

			$supplier = Supplier::select(['name', 'code'])
			->where('code', '=', $value['forecast']['SuppCode'] )
			->first();

			$value['supplier'] = $supplier;
			// $request->input_date = $value['forecast']['']

			$value['pck31'] = $this->pck31($request);
		}

		$meta = collect([
			'message' => $message,
			'count' => count($toolpart)
		]);

		$toolpart = $meta->merge($toolpart);

		return $toolpart;
	}

	public function indexTEUJADI(Request $request){
		//we need to specify trans_date as default parameter

		
		$tool = Tool::select([
			'id',
			'no',
			'name',
			'no_of_tooling',
			'start_value',
			'guarantee_shoot',
			'delivery_date',
			'supplier_id',
		])
		->get();

		foreach ($tool as $key => $value) {
			if ( $value->hasToolPart() ) {
				$value->toolpart();
				$value->details;	
			}else{
				$tool->forget($key);
			}
		}


		return $tool;
	}




}
