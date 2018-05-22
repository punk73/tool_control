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

	public function forecast(Request $request){ //sepertinya ini sudah tidak dipakai, karena get forecast ada di tool model

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
	
	public function index(Request $request){
		$dataController = $this;

		if (isset($request->trans_date) && $request->trans_date != '') {
			$trans_date = $request->trans_date;
		}else{
			$trans_date = date('Y-m-d'); //secara default refer ke hari ini;
		}

		
		$limit = (isset($request->limit)) ? $request->limit : 15 ;

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

			'detail.machine' => function($machine) use ($trans_date){
				$machine->select([
					//'id', //id harus selalu ikut
					'tool_id', //tool id harus selalu ikut, karena jadi foreign key
					'counter',
					'tanggal',
					'note',
				])
				->where('tanggal', '<=', $trans_date )
				->orderBy('id','desc'); //jika disatu trans_date ada dua, maka muncul yg paling baru diinput.
				// ->orderBy('tanggal', 'desc')
			},

			'supplier:id,name,code' // -->get supplier
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

			//show the danger tools
			//yg habis dalam 6 bulan kedepan disebut danger
			if (isset($request->danger) && $request->danger == true) {
				$tools = $tools->whereHas('details', function ($query) use ($trans_date){
					$query
					//dengan begini danger hanya show yg hari ini merah saja;
					->where('trans_date', $trans_date )
					->where('guarantee_after_forecast', '<=', 6);
				});
			}

			//show the safe tools
			//yg tidak habis dalam 6 bulan ke depan
			if (isset($request->safe) && $request->safe == true) {
				$tools = $tools->whereHas('details', function ($query) use ($trans_date){
					$query
					//dengan begini danger hanya show yg hari ini merah saja;
					->where('trans_date', $trans_date )
					->where('guarantee_after_forecast', '>', 6);
				});
			}

			//show the warning tools
			if (isset($request->warning) && $request->warning == true) {
				$tools = $tools->whereHas('details', function ($query) use ($trans_date){
					$query
					//dengan begini danger hanya show yg hari ini merah saja;
					->where('trans_date', $trans_date )
					->where('guarantee_after_forecast', '<=', 6 );
				});
			}

			if (isset($request->hard_load ) && $request->hard_load  == true) {
				DB::table('tool_details')->where('trans_date', $trans_date )->delete();
				DB::table('part_details')->where('trans_date', $trans_date )->delete();

				// return;
			}


			//show the warning tools;
			
		
		/*End Of Searching Code*/

		// get Query generated by laravel
		/*$tools = $tools->toSql();
		return ['query' => $tools];*/

		$tools = $tools->paginate($limit);
		// return $tools;
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
			$total_delivery = $tool->part->total_delivery; 
			if ($tool->detail == null ) {
				//total delivery disini adalah total delivery setelah ditambah forecast

				$is_suffix_number = (int) $tool->part->pivot->is_independent;
				
				//ceil = pembulatan ke atas
				$total_shoot = /**/ ceil( ( $total_delivery / (float) $tool->part->pivot->cavity ) );
				$total_shoot_after_forecast = ceil( ( ($total_delivery + $tool->forecast->total) / (float) $tool->part->pivot->cavity ) );
				//save to tool_details
				$toolDetail = new Tool_detail;
				$toolDetail->tool_id  = $tool->id;
				$toolDetail->total_shoot = $total_shoot;
				$toolDetail->trans_date = $trans_date;
				/*balance shoot tidak menggunakan total shoot aktual melainkan total shoot after forecast*/
				$toolDetail->balance_shoot = ($tool->guarantee_shoot - $total_shoot_after_forecast );

				if ($tool->forecast->total == 0) {
					$tool->forecast->total = 1; //kalau forecast nya ga ada, anggap aja jadi satu. biar ga division by zero
				}

				$toolDetail->guarantee_after_forecast = ($toolDetail->balance_shoot * (float) $tool->part->pivot->cavity ) / ($tool->forecast->total / 6 ) ; //we need to find or get the forecast first;
				
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


				if ($tool->detail->total_shoot != ( $tool->part->total_shoot_based_on_part+$tool->start_value ) ) {
					//do the updating over here;
					$toolDetail = Tool_detail::where('tool_id', $tool->detail->tool_id )
					->where('trans_date', $trans_date)
					->first();
					$tool->is_same = $toolDetail ;
					if (!empty( $toolDetail ) ) {
						// total shoot gausah dibagi cavity lagi, kan udah total shoot bukan total delivery
						$total_shoot = ceil( ($tool->part->total_shoot_based_on_part+$tool->start_value));/*/ (float) $tool->part->pivot->cavity) ;*/
						$total_shoot_after_forecast = ceil( ( ($total_delivery + $tool->forecast->total) / (float) $tool->part->pivot->cavity ) );
						$toolDetail->total_shoot = $total_shoot;
						$toolDetail->trans_date = $trans_date;
						$toolDetail->balance_shoot = ceil(($tool->guarantee_shoot - $total_shoot_after_forecast ));
						$toolDetail->guarantee_after_forecast = ($toolDetail->balance_shoot * (float) $tool->part->pivot->cavity ) / ($tool->forecast->total / 6 ) ;
						$toolDetail->save();
					}
					
				}
			}

		});

		return $tools;
	}

	public function indexStoreProcedure(Request $request){
		//ambil semua toolpart
		//ambil semua toolpart.part
 		//ambil part.forecast;
			
			//kalau kosong, isi forecastnya sebagai 0;
		//ambil tollpart.part.detail
			//kalau kosong
			//ambil data part.first_value + (data pck31 dari tanggal part.date_of_first_value s/d trans_date)
			//store ke part.detail
		//store ke part_temporary
		//ambil semua tools dari toolpart
		//ambil tool.detail
			//kalau kosong
				//ambil part detail total delivery / cavity. store as total shoot;
				//cek apakah suffix no atau tidak.
				//kalau suffix
					//sum total shoot
				//kalau nonSuffix
					//get max()
		//ambil machine counter

		//cek apakah bisa run exec query dari sini
		$result = DB::select('exec displayMainData "2018-05-04" ');
		return $result;
	}

	public function getCount(Request $request){
		
		if (isset($request->trans_date) && $request->trans_date != '') {
			$trans_date = $request->trans_date;	
		}else{
			$trans_date = date('Y-m-d');
		}

		$tools = Tool::select(DB::raw('
			sum(case when guarantee_after_forecast <= 6 then 1 else 0 end) danger, 
			sum(case when guarantee_after_forecast > 6 then 1 else 0 end) safe,
			--sum(case when guarantee_after_forecast <= 6 then 1 else 0 end) warning,
			tool_details.trans_date
		'))->leftJoin('tool_details', 'tools.id', '=', 'tool_details.tool_id' )
		->where('trans_date', $trans_date )
		->groupBy('trans_date')
		->first();

		return [
			'_meta' => [
				'message' => 'OK' 
			],
			'data' =>$tools
		];
	}

	public function deleteDetails(Request $request){
		
		if (isset($request->trans_date) && $request->trans_date != '') {
			$trans_date = $request->trans_date;
		}else{
			$trans_date = date('Y-m-d'); //secara default refer ke hari ini;
		}

		$toolDetails = Tool_detail::where('trans_date', $trans_date )->get();
		$partDetails = Part_detail::where('trans_date', $trans_date )->get();

		foreach ($toolDetail as $key => $detail) {
			$detail->delete();
		}

		foreach ($partDetails as $key => $detail) {
			$detail->delete();
		}
	}
	//fillDetail on both tool and part
	public function fillDetails($trans_date = null){
		$dataController = $this;

		if (!isset($trans_date) || $trans_date == null) {
			$trans_date= date('Y-m-d');
		}

		$this->fillPartDetails($trans_date);

		$tools = Tool::has('parts')
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

			'detail.machine' => function($machine) use ($trans_date){
				$machine->select([
					//'id', //id harus selalu ikut
					'tool_id', //tool id harus selalu ikut, karena jadi foreign key
					'counter',
					'tanggal',
					'note',
				])
				->where('tanggal', '<=', $trans_date );
				// ->orderBy('tanggal', 'desc')
			},

			'supplier' // -->get supplier
		]);

		$tools = $tools->chunk(200, function($tools) use ($dataController, $trans_date){
			//perulangan dari tools 
			$tools->each(function($tool, $key) use ($dataController, $trans_date) {

				$tool->partWithHighestTotalDelivery($trans_date); //get highestTotalDelivery in 

				//has total shoot in tool details
				if ($tool->detail == null ) {
					$total_delivery = $tool->part->total_delivery;
					$is_suffix_number = (int) $tool->part->pivot->is_independent;
					
					//ceil = pembulatan ke atas
					$total_shoot = /**/ ceil( ( $total_delivery / (float) $tool->part->pivot->cavity ) );
					//save to tool_details
					$toolDetail = new Tool_detail;
					$toolDetail->tool_id  = $tool->id;
					$toolDetail->total_shoot = $total_shoot;
					$toolDetail->trans_date = $trans_date;
					$toolDetail->balance_shoot = ceil(($tool->guarantee_shoot - $total_shoot ));

					if ($tool->forecast->total == 0) {
						$tool->forecast->total = 1; //kalau forecast nya ga ada, anggap aja jadi satu. biar ga division by zero
					}

					$toolDetail->guarantee_after_forecast = ($toolDetail->balance_shoot * (float) $tool->part->pivot->cavity ) / ($tool->forecast->total / 6) ; //we need to find or get the forecast first;
					
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
		});

		return $tools;
	}

	//only fill part details
	public function fillPartDetails($trans_date = null){
		if (!isset($trans_date) || $trans_date == null) {
			$trans_date= date('Y-m-d');
		}
		// return $trans_date;
		$toolparts = ToolPart::with('part.detail');

		$toolparts = $toolparts->chunk(200, function($toolparts) use ($trans_date){
			$toolparts->each(function($toolpart) use($trans_date){
				if($toolpart->part->detail == null){
					$pck31 = $toolpart->part->pck31($toolpart->part->no, $toolpart->part->date_of_first_value, date('Y-m-d'));
					$toolpart->pck31 = $pck31;
					if (!empty($pck31)) {
						# code...
						$part_details = new Part_detail;
						$part_details->part_id = $toolpart->part->id;
						$part_details->total_delivery = $pck31->total_qty;
						$part_details->total_qty = 0;//ini harusnya ambil dari forecast
						$part_details->trans_date = $trans_date;
						$part_details->save();
					}
				}
			});	
		});
		// $toolparts = $toolparts->paginate();

		return $toolparts;

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
		$dataController = $this;

		if (isset($request->trans_date) && $request->trans_date != '') {
			$trans_date = $request->trans_date;
		}else{
			$trans_date = date('Y-m-d'); //secara default refer ke hari ini;
		}

		
		$limit = (isset($request->limit)) ? $request->limit : 15 ;

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
				]);//->orderBy('total_delivery', 'desc'); //should always return one result based on trans_date

				if (isset($trans_date) && $trans_date != null ) {
					$part_detail = $part_detail->where('trans_date', '=', $trans_date );
				}

				// $max = $part_detail->max('total_delivery');
				// $part_detail = $part_detail->where('total_delivery', $max );


			}, ///sudah dihandle partWithHighestTotalDelivery
			
			
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

			'detail.machine' => function($machine) use ($trans_date){
				$machine->select([
					//'id', //id harus selalu ikut
					'tool_id', //tool id harus selalu ikut, karena jadi foreign key
					'counter',
					'tanggal',
					'note',
				])
				->where('tanggal', '<=', $trans_date )
				->orderBy('id','desc'); //jika disatu trans_date ada dua, maka muncul yg paling baru diinput.
				// ->orderBy('tanggal', 'desc')
			},

			'supplier' // -->get supplier
		]);

		$tools = $tools->get();
		return $tools;

	}

}
