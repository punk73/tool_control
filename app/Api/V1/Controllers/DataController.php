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

use DB;

class DataController extends Controller
{
    //helper api
	use Helpers;

	public function index2(Request $request){
		$toolpart = new ToolPartController;

		$data = $toolpart->index($request)['data'];
		$newData = [];

		foreach ($data as $key => $value) {
			$supplier_id = $value['tool']['supplier_id'];
			$request->part_no = $value['part']['no'];

			$supplier = Supplier::find($supplier_id);
			$forecast = $this->forecast($request);
			$pck31 = $this->pck31($request); //diisi dengan request->part no
			
			
			// set Value;
			$value['supplier'] = $supplier;
			$value['pck31'] = $pck31;
			$value['forecast'] = $forecast;

			$newData[] = $value;
		}

		return $newData;

	}

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

		if (isset($request->part_id) && $request->part_id != '' ) {
			$toolpart = $toolpart->where('part_id', '=', $request->part_id );
		}

		if (isset($request->tool_id) && $request->tool_id != '' ) {
			$toolpart = $toolpart->where('tool_id', '=', $request->tool_id );
		}

		try {
			$toolpart = $toolpart->get();
		} catch (Exception $e) {
			$message = $e;
		}


		foreach ($toolpart as $key => $value) {
			$value->parts();
			$value->tools();
			
			$request->part_no = $value['part']['no'];
			$supplier_id = $value['tool']['supplier_id'];
			$supplier = Supplier::select(['name', 'code'])->find($supplier_id);

			$value['supplier'] = $supplier;
			$value['pck31'] = $this->pck31($request);
			$value['forecast'] = $this->forecast($request);
		}

		return [
			'_meta' => [
				'message' => $message,
				'count' => count($toolpart)
			],
			'data'=>	$toolpart
		];


	}


}
