<?php

namespace App\Api\V1\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JWTAuth;
use Dingo\Api\Routing\Helpers;
use App\Pck31;
use DB;

class Pck31Controller extends Controller
{
    //we need to specify file path and the file to be imported here
    public function sync(){
    	set_time_limit(60);

        $path = storage_path('app\data.csv'); //path ini harus bisa jadi paramter.

        $header = [
        	'month',
        	'vcode', 
        	'part_no', 
        	'part_name', 
        	'input_date', 
        	'do_number',
        	'po_number', 
        	'seq', 
        	'qty', 
        	'price', 
        	'amt',
        	'input_by'
    	];
        $arrayFromCsv = $this->csvToArray($path, ',', $header);

        $data =[];
        foreach ($arrayFromCsv as $key => $value) {
        	
        	$newValue = [];
        	foreach ($value as $i => $j) {
        		# code...
        		$newValue[$i] = str_replace(" ", "", $j ); //change value to int here
        	}

        	$newValue['price'] = (int) $newValue['price'];
        	$newValue['qty'] = (int) $newValue['qty'];
        	$data[] = $newValue;	

        	// $pck31 = new Pck31;
        	Pck31::insert($newValue);
        }

        return $data;
    }

    public function csvToArray($filename = '', $delimiter = ',', array $header)
	{
	    if (!file_exists($filename) || !is_readable($filename))
	        return false;

	    // $header = null;
	    $data = array();
	    if (($handle = fopen($filename, 'r')) !== false)
	    {
	        while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
	        {
	        	if (count( $row ) < 12 ) {
	        		continue;
	        	}
			    $data[] = array_combine($header, $row);
	        }
	        fclose($handle);
	    }

	    return $data;
	}

	public function index(Request $request){ //get summary per part_no
		// $pck31 = Pck31::all();
		//set parameter
			if (isset($request->month)) {
				$month = $request->month;
			}else{
				$month = date('m');
			}

			if (isset($request->year)) {
				$year = $request->year;
			}else{
				$year = date('Y');
			}

			if (isset($request->monthyear)) {
				$monthYear = $request->monthyear;
			}else{
				$monthYear = $year . $month;
			}
		// finish set paramter
		//return ['month' => $year . $month];

		$pck31 = Pck31::select(
			DB::raw('month,part_no,sum(qty) as total_qty')
		)
		->where('month', $monthYear)
		->groupBy('part_no')
		->groupBy('month')
		->get();

		return [
			'_meta' => [
				'count' => count($pck31),
				'message' => 'OK'
			],
			'data' =>	$pck31
		];
	}


	//PCK31 akan dihandle oleh pak yunus
	public function copy(){
		$path = '\\\svrfile\EDI\BACKUP\PCK31WEB\\';
		$today = date('Ymd');

		$filename = $path . 'PCK31WEB'.$today.'.txt';
		// return $filename;
		$localpath = storage_path('app\data_hasil_copy.csv');

		$isSuccess = copy($filename, $localpath );
		if ($isSuccess) {
			return "sukses";
		}else{
			return "Gaggal";
		}
	}

	public function update(){
		
	}

	public function delete(){
		
	}

}
