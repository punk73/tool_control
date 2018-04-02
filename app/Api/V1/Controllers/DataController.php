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

	public function indexBackUp(Request $request){
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
			$value->tools();
			
			$request->part_no = $value['part']['no'];
			$value['forecast'] = $this->forecast($request);
			
			

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




}
