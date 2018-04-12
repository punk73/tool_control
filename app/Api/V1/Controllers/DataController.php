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
use App\tool_detail;
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
		
		if (isset($pck31['data'][0])) {
		 	return $pck31['data'][0];
		} else{
		 	return null;
		}
	}

	public function forecast(Request $request){

		$forecast = new ForecastController;
		$forecast = $forecast->index($request);
		if ($forecast != '') {
			if ($forecast[0]) {
				# code...
				return $forecast[0];
			}else{
				return null;
			}
		}

	}

	public function indexCurrentBackUp(Request $request){
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
			$supplier = Supplier::select(['name', 'code'])
			->where('code', '=', $value['forecast']['SuppCode'] )
			->first();
			
			//hapus model jika forecast tidak ditemukan.
			if ($value['forecast'] == null ) {
				$toolpart->forget($key);
				continue;
			}

			$value['supplier'] = $supplier;
			// $request->input_date = $value['forecast']['']
			$value['pck31'] = $this->pck31($request);

		}


		$meta = collect([
			'message' => $message,
			'count' => count($toolpart)
		]);

		$toolpart = $meta->merge($toolpart);
		$toolpart['data'] = array_values( $toolpart['data'] );
		return $toolpart;
	}

	public function indexBackUp(Request $request){
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

	public function index (Request $request){
		
		if (isset($request->trans_date) && $request->trans_date != '') {
			$trans_date = $request->trans_date;
		}else{
			// $trans_date = date('Y-m-d');
			$trans_date = null;

		}

		// return $trans_date;

		//get tool, dengan semua data yang terkait di dalamnya.
		$tools = Tool::select([
			'id',
			'no',
			'name',
			'no_of_tooling',
			'start_value',
			'guarantee_shoot',
			'delivery_date',
			'supplier_id',
		])->with([
			'parts' => function ($part){
				// $part->where('parts.id', 76); //jalan ! bisa buat query yg paling gede first value nya
				$part->select([
					'parts.id',
					'no',
					'name',
					'supplier_id',
					'model',
					'first_value',
					'date_of_first_value',
				]) ; //->whereHas biggest total part
			},

			'parts.details' => function ($part_detail) use ($trans_date) {
				// $detail->select(DB::raw('select max ')) //select max total delivery
				$part_detail->select([
					'id',
					'part_id',
					'total_delivery',
					'total_qty',
					'trans_date',
				]); //should always return one result based on trans_date

				if (isset($trans_date) && $trans_date != null ) {
					$part_detail = $part_detail->where('trans_date', '=', $trans_date );
				}
			}, 

			'details' => function ($tool_detail) use ($trans_date) { //
				$tool_detail->select([
					'id',
					'tool_id',
					'total_shoot',
					'guarantee_after_forecast',
					'balance_shoot',
					'trans_date'
				]); //should always return one result based on trans_date
				
				if (isset($trans_date) && $trans_date != null ) {
					$tool_detail = $tool_detail->where('trans_date', '=', $trans_date );
				}
			},

			'supplier:id,name,code'
		])
		->has('parts') // yang ada di table toolpart;
		->get()
		->each(function($tool){
			$highest_total_shoot = 0;
			foreach ($tool->parts as $key => $part) {
				//cek pivot nya, apakah independent atau tidak
				if ($part->pivot->is_independent == '0') {
					//get salah satu
					$part->is_independent = 0;
					$part->cavity = (int) $part->pivot->cavity;
					

					$detail_total_delivery = 0;
					foreach ($part->details as $key => $detail ) {
						//get highest $detail->total_delivery
						if ($detail_total_delivery < $detail->total_delivery ) {
							$detail_total_delivery = $detail->total_delivery;
						}
					}
					$part->highest_total_delivery = $detail_total_delivery;
					//setting total shoot for tool
					if ($highest_total_shoot < ($detail_total_delivery / $part->cavity) ) {
						$highest_total_shoot = ($detail_total_delivery / $part->cavity); 
					}

				}else{
					//get semua tapi di summary dulu
					$part->is_independent = 1;
				}
			}
			//get highest total shoot, based on total delivery / cavity from parts data.
			$tool->highest_total_shoot = $highest_total_shoot;

			//get highest total_shoot basedon details
			$highest_total_shoot_based_on_details = 0;
			foreach ($tool->details as $key => $tool_detail) {
				if ($highest_total_shoot_based_on_details < $tool_detail->total_shoot ) {
					$highest_total_shoot_based_on_details = $tool_detail->total_shoot;
				}
			}
			//setup hasil pencarian ke object tool
			$tool->highest_total_shoot_based_on_details = $highest_total_shoot_based_on_details;
			
			if ($tool->highest_total_shoot_based_on_details < $tool->highest_total_shoot ) {
				//insert ke table tool_detail
				$toolDetail = new tool_detail;
				$toolDetail->tool_id = $tool->id;
				$toolDetail->total_shoot = ceil( (int) $tool->highest_total_shoot );
				$toolDetail->balance_shoot = ceil( ( $tool->guarantee_shoot - $tool->highest_total_shoot ) );
				$toolDetail->trans_date = date('Y-m-d'); //we need to find or get the forecast first;
				$toolDetail->guarantee_after_forecast = 0; //we need to find or get the forecast first;
				
				$toolDetail->save();
			}


		});

		return $tools;
	}




}
