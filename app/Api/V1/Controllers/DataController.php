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
use App\Tool_detail;
use App\Part_detail;
use App\Api\V1\Controllers\ToolPartController;
use App\Api\V1\Controllers\Pck31Controller;
use App\Api\V1\Controllers\ForecastController;
use Carbon\Carbon;
use DB;

class DataController extends Controller
{
    //helper api
	use Helpers;


	public function pck31BackUp(Request $request){
		$pck31 = new Pck31Controller;
		// $request->part_no = '1SS355VM9';
		$pck31 = $pck31->index($request);
		
		if (isset($pck31['data'][0])) {
		 	return $pck31['data'][0];
		} else{
		 	return null;
		}
	}

	public function pck31($partNo=null, $startDate = null, $finishDate = null){
		//setup startDate
		if (is_null($startDate)) {
			$startDate = '1990/01/01';
		}else{
			$startDate = Carbon::parse($startDate)->format('Y/m/d');
		}

		//setup finish date
		if (is_null($finishDate)) {
			$finishDate = date('Y/m/d');
		}else{
			$finishDate = Carbon::parse($finishDate)->format('Y/m/d');
		}

		// return $startDate;

		if (is_null($partNo)) {
			throw new Exception("part no can't be empty", 1);				
		}else{
			trim($partNo);
		}

		$pck31 = Pck31::select(
			DB::raw('month,part_no,sum(qty) as total_qty')
		)
		->where('part_no', $partNo )
		->whereBetween('input_date', [$startDate, $finishDate ] )
		->groupBy('part_no')
		->groupBy('month');

		$pck31= $pck31->first();
		return $pck31;
	
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

	/*public function indexCurrentBackUp(Request $request){
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
		
		if (isset($request->trans_date) && $request->trans_date != '') {
			$trans_date = $request->trans_date;
		}else{
			// $trans_date = date('Y-m-d');
			$trans_date = null;
		}

		// return $trans_date;

		// $tools = Tool::with(['parts.getHighestTotalDelivery'])->get();
		// return $tools;

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
				])->orderBy('total_delivery', 'desc'); //should always return one result based on trans_date

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
				])->orderBy('total_shoot', 'desc'); //should always return one result based on trans_date
				
				if (isset($trans_date) && $trans_date != null ) {
					$tool_detail = $tool_detail->where('trans_date', '=', $trans_date );
				}
			},

			'parts.getHighestTotalDelivery' => function ($highest_total_delivery) use ($trans_date){

			},

			'getHighestTotalShoot' => function ($highest_total_shoot) use ($trans_date){
				if (isset($trans_date)) {
					$highest_total_shoot->where('trans_date', '=', $trans_date );
				}
			},

			'supplier:id,name,code'
		])
		->has('parts') // yang ada di table toolpart;
		->get()
		->each(function($tool){
			//get total shoot based on part delivery
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

	public function index2(Request $request){
		$dataController = $this;

		if (isset($request->trans_date) && $request->trans_date != '') {
			$trans_date = $request->trans_date;
		}else{
			$trans_date = date('Y-m-d'); //secara default refer ke hari ini;
		}

		//get all data that exist on pivot table
		$tools = Tool::select([
			'id',
			'no',
			'name',
			'no_of_tooling',
			'start_value',
			'guarantee_shoot',
			'delivery_date',
			'supplier_id',
		])
		->has('parts') // yang ada di table toolpart;
		->with([ //get total shoot dari table tool_details

			'getHighestTotalShoot' => function ($highest_total_shoot) use ($trans_date){
				$highest_total_shoot->where('trans_date', '=', $trans_date );
			},

			'parts.getHighestTotalDelivery' => function ($highest_total_delivery) use ($trans_date){
				$highest_total_delivery->where('trans_date', '=', $trans_date );
			},

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
				])->orderBy('total_delivery', 'desc'); //should always return one result based on trans_date

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
				])->orderBy('total_shoot', 'desc'); //should always return one result based on trans_date
				
				if (isset($trans_date) && $trans_date != null ) {
					$tool_detail = $tool_detail->where('trans_date', '=', $trans_date );
				}
			},

			'getHighestTotalShoot' => function ($highest_total_shoot) use ($trans_date){
				if (isset($trans_date)) {
					$highest_total_shoot->where('trans_date', '=', $trans_date );
				}
			},

			'supplier:id,name,code'

		])->paginate();

		$tools->each(function($tool) use ($dataController, $request, $trans_date ) {
			//cek apakah sudah ada total shoot pada table tool_details
			if ( $tool->getHighestTotalShoot == null ) {
				//get part dengan total delivery terbesar dengan trans date yang sama dengan data tool_details.trans_date

				$highest_total_shoot = 0;
				//perulangan parts
				foreach ($tool->parts as $key => $part) {
					//cek apakah ada total_delivery pada table part_details (with specific trans_date)
					if ( $part->getHighestTotalDelivery == null  ) {
						//import data from pck31
						$pck31 = $dataController->pck31($request);
						// $part->pck31 = $pck31;
						
						//insert this data to part_details
						$part_detail = new Part_detail;
						$part_detail->part_id = $part->id;
						$part_detail->total_delivery = $pck31->total_qty;
						$part_detail->total_qty = 0;//$part->id;
						$part_detail->trans_date = $trans_date;
						$part_detail->save();
					}

					//get highest total shoot based on part_details.total_delivery / toolpart.cavity
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

					// //get forecast
					// $request->part_no = $part->no;
					// $part->forecast = $dataController->forecast($request);

				}

				//insert into table tool_details.total_shoot
				//insert ke table tool_detail
				$toolDetail = new tool_detail;
				$toolDetail->tool_id = $tool->id;
				$toolDetail->total_shoot = ceil( (int) $highest_total_shoot );
				$toolDetail->balance_shoot = ceil( ( $tool->guarantee_shoot - $highest_total_shoot ) );
				$toolDetail->trans_date = $trans_date; //we need to find or get the forecast first;
				$toolDetail->guarantee_after_forecast = 0; //we need to find or get the forecast first;
				$toolDetail->save();
				//setup so that we can get total shot directly
				$tool->getHighestTotalShoot = $toolDetail;

			}

		});

		return $tools;
	}*/

	public function index(Request $request){
		$dataController = $this;

		if (isset($request->trans_date) && $request->trans_date != '') {
			$trans_date = $request->trans_date;
		}else{
			$trans_date = date('Y-m-d'); //secara default refer ke hari ini;
		}

		$tools = Tool::has('parts')
		// ->where('id', 6 )
		->with([
			// 'parts', ///sudah dihandle partWithHighestTotalDelivery
			
			'parts.details' => function ($part_detail) use ($trans_date) {
				// $detail->select(DB::raw('select max ')) //select max total delivery
				$part_detail->select([
					'id',
					'part_id',
					'total_delivery',
					'total_qty',
					'trans_date',
				])->orderBy('total_delivery', 'desc'); //should always return one result based on trans_date

				if (isset($trans_date) && $trans_date != null ) {
					$part_detail = $part_detail->where('trans_date', '=', $trans_date );
				}
			}, ///sudah dihandle partWithHighestTotalDelivery
			
			// 'details',  ///sudah dihandle getHighestTotalShoot
			
			'detail' => function ($detail) use ($trans_date){
				$detail->select([
					'id',
					'tool_id',
					'total_shoot',
					'guarantee_after_forecast',
					'balance_shoot',
					'trans_date',
				]);

				if (isset($trans_date)) {
					$detail = $detail->where('trans_date', '=', $trans_date );
				}
			},// -->get highest total shoot in tool_details;

			'supplier' // -->get supplier
		]);

		/*Searching Code*/
			//search by no
			if (isset($request->tool_no) && $request->tool_no != '' ) {
				$tools = $tools->where('no', 'like', $request->tool_no . '%' );			
			}
			//search by namne
			if (isset($request->tool_name) && $request->tool_name != '' ) {
				$tools = $tools->where('name', 'like', $request->tool_name . '%' );			
			}
			//search by part_no
			if (isset($request->part_no) && $request->part_no != '' ) {
				$tools = $tools->whereHas('parts', function($part) use($request){
					$part->where('no', 'like', $request->part_no . '%');
				});
			}

			//search by supplier name
			if (isset($request->supplier_name) && $request->supplier_name != '' ) {
				$tools = $tools->whereHas('supplier', function($supplier) use($request){
					$supplier->where('name', 'like', $request->supplier_name . '%');
				});
			}

			//search by model
			if (isset($request->model) && $request->model != '' ) {
				$tools = $tools->where('model', 'like', $request->model . '%' );			
			}

			//search by no_of_tooling
			if (isset($request->no_of_tooling) && $request->no_of_tooling != '' ) {
				$tools = $tools->where('no_of_tooling', 'like', $request->no_of_tooling . '%' );			
			}

			//search by cavity
			if (isset($request->cavity) && $request->cavity != '' ) {
				$tools = $tools->whereHas('parts',  function ($query) use ($request) {
					$query->where('cavity', '=', $request->cavity );
				});
			}
		/*End Of Searching Code*/


		$tools = $tools->paginate();

		//perulangan dari tools 
		$tools->each(function($tool, $key) use ($dataController, $trans_date, $request) {

			$tool->partWithHighestTotalDelivery($trans_date); //get highestTotalDelivery in part_details //set part in 
			
			//has Has highest total delivery in part_details ?
				// if ( $tool->part->detail == null ) { //if don't have
				// 	// $tool->result = 'tool part == null';
				// 	foreach ($tool->parts as $key => $part) {
				// 		/* Important Noted
				// 			harus cek dulu apakah disini ada yang semi part atau tidak, karena kalau semi part seharusnya yang dicari di pck31 itu semi part nya. bkn part nya;
				// 		*/

				// 		//kalau bukan semi part, maka langsung isi
				// 		//bkn semi part = parentPart == empty
				// 		if ( $part->parentParts->isEmpty() ) {
				// 			//setting paramter, untuk non semi part;
				// 			$request->part_no = $part->no;
				// 			$request->input_date = $trans_date;

				// 			// $part->is_semi_part = false;
				// 			//cek apakah part->detail sudah diinput sebelumnya;
				// 			//kalau sudah, tidak usah input lagi;
				// 			if ($part->detail == null ) {
				// 				# code...
				// 				$part->pck31 = $dataController->pck31($part->no, $part->date_of_first_value, $trans_date);
				// 				if ($part->pck31 != null ) {
				// 					# code...
				// 					//save result into part details
				// 					$part_detail = new Part_detail;
				// 					$part_detail->part_id = $part->id;
				// 					$part_detail->total_delivery = $part->pck31->total_qty;
				// 					$part_detail->total_qty = 0;//$part->id;
				// 					$part_detail->trans_date = $trans_date;
				// 					$part_detail->save();

				// 					//benerin total_delivery nya. karena tool.part.detail masih kosong.
				// 					$tool->part->total_delivery += $part->pck31->total_qty;
				// 				}
				// 			}
							
				// 		}else {
				// 			//semi part disini;
				// 			//setup value awal untuk save ke detail
				// 			foreach ($part->parentParts as $key => $parentPart ) {
				// 				$parentPart->parentPart->detail; //get the detail

				// 				if ($parentPart->parentPart->detail == null ) {
				// 					// $parentPartPartNo = $parentPart->parentPart->no;
				// 					// $request->part_no = $parentPartPartNo;
				// 					// $request->input_date = $trans_date;
				// 					// $part->is_semi_part = false;
				// 					$part->pck31 = $dataController->pck31($parentPart->parentPart->no, $parentPart->parentPart->date_of_first_value, $trans_date  );
				// 					if ($part->pck31 != null ) {
				// 						# code...
				// 						//save part into part details
				// 						$part_detail = new Part_detail;
										
				// 						// important note!
				// 						//save detail ke part id, bkn ke parentpart.id karena memang kita cuman ngambil data sj di parent, store nya tetep di child part;

				// 						$part_detail->part_id = $part->id;
				// 						$part_detail->total_delivery = $part->pck31->total_qty;
				// 						$part_detail->total_qty = 0;//$part->id;
				// 						$part_detail->trans_date = $trans_date;
				// 						$part_detail->save();
				// 						//benerin total_delivery nya. karena tool.part.detail masih kosong.
				// 						$tool->part->total_delivery += $part->pck31->total_qty;
				// 					}
				// 				}
								
				// 			}
				// 		}
				// 	}
			// }

			//has total shoot in tool details
			if ($tool->detail == null ) {
				$total_delivery = $tool->part->total_delivery;
				$is_suffix_number = (int) $tool->part->pivot->is_independent;
				
				//ceil = pembulatan ke atas
				$total_shoot = /**/ ceil( ( $total_delivery / (int) $tool->part->pivot->cavity ) );
				//save to tool_details
				$toolDetail = new Tool_detail;
				$toolDetail->tool_id  = $tool->id;
				$toolDetail->total_shoot = $total_shoot;
				$toolDetail->trans_date = $trans_date;
				$toolDetail->balance_shoot = ceil(($tool->guarantee_shoot - $total_shoot ));

				if ($tool->forecast->total == 0) {
					$tool->forecast->total = 1; //kalau forecast nya ga ada, anggap aja jadi satu. biar ga division by zero
				}

				$toolDetail->guarantee_after_forecast = ($toolDetail->balance_shoot * (int) $tool->part->pivot->cavity ) / ($tool->forecast->total / 6) ; //we need to find or get the forecast first;
				
				// $toolDetail->guarantee_after_forecast = 0;
				$toolDetail->save();

				//setup total shoot di tool
				$tool->total_shoot = $total_shoot;
				$tool->trans_date = $trans_date;
				$tool->balance_shoot = $toolDetail->balance_shoot;
				$tool->guarantee_after_forecast = $toolDetail->guarantee_after_forecast;

			}else {
				//setup nya ambil dari detail
				$tool->total_shoot = $tool->detail->total_shoot;
				$tool->trans_date = $tool->detail->trans_date;
				$tool->balance_shoot = $tool->detail->balance_shoot;
				$tool->guarantee_after_forecast = $tool->detail->guarantee_after_forecast;

				if ($tool->detail->total_shoot != ( $tool->part->total_shoot_based_on_part + $tool->start_value ) ) {
					//do the updating over here;
					$toolDetail = Tool_detail::where('tool_id', $tool->detail->tool_id )
					->where('trans_date', $trans_date)
					->first();
					$tool->is_same = $toolDetail ;
					if (!empty( $toolDetail ) ) {
						$total_shoot = ( $tool->part->total_shoot_based_on_part + $tool->start_value );

						$toolDetail->total_shoot = $total_shoot;
						$toolDetail->trans_date = $trans_date;
						$toolDetail->balance_shoot = ceil(($tool->guarantee_shoot - $total_shoot ));
						$toolDetail->save();
					}
					
				}
			}
		});

		return $tools;
	}

	public function show(Request $request, $tool_id){
		$dataController = $this;

		/*if (isset($request->trans_date) && $request->trans_date != '') {
			$trans_date = $request->trans_date;
		}else{
			$trans_date = date('Y-m-d'); //secara default refer ke hari ini;
		}*/

		$tools = tool::has('parts')
		->with([
			// 'parts', ///sudah dihandle partWithHighestTotalDelivery
			
			'parts.details' => function ($part_detail) {
				// $detail->select(DB::raw('select max ')) //select max total delivery
				$part_detail->select([
					'id',
					'part_id',
					'total_delivery',
					'total_qty',
					'trans_date',
				])->orderBy('total_delivery', 'desc'); //should always return one result based on trans_date

				
			}, ///sudah dihandle partWithHighestTotalDelivery
			
			// 'details',  ///sudah dihandle getHighestTotalShoot
			
			'details' => function ($detail) {
				$detail->select([
					'id',
					'tool_id',
					'total_shoot',
					'guarantee_after_forecast',
					'balance_shoot',
					'trans_date',
				]);				
			},// -->get highest total shoot in tool_details;

			'supplier' => function ($supplier){
				$supplier->select([
					"id",
		            "name",
		            "code",
				]);
			} // -->get supplier
		])->where('id', $tool_id )->first() ; //it's always return one value;

		$tools->each(function($tool){
			foreach ($tool->parts as $key => $part) {
				//get pck31, this method takes partno, startdate, finish date
				foreach ($part->details as $key => $detail) {
					# code...
					if ($detail == null) {
						continue;
					}

					$detail->pck31 = $part->pck31($part->no, $part->date_of_first_value, $detail->trans_date );

					//forecast take two paramter, partno & trans_date
					$detail->forecast = $tool->forecast($part->no ,$detail->trans_date);
				}
			}
		});

		return [
			'_meta' => [
				'message' => 'OK' 
			],
			'data' =>$tools
		];

	}

	public function test(Request $request){
		/*$tools = Tool::has('parts')->take(3)->get();

		$tools->each(function($model){
			$model->partWithHighestTotalDelivery('2018-04-19');
		});

		return $tools;	*/

		$parts = Part::has('tools')
		->get();

		//so the problem is just time !
		foreach ($parts as $key => $part) {
			$part->berapa = $part->detail();
		}


		return $parts;
	}


}
