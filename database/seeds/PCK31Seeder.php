<?php

use Illuminate\Database\Seeder;
use App\Pck31;

class PCK31Seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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

}
