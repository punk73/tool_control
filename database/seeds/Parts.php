<?php

use Illuminate\Database\Seeder;
use App\Part;
use App\Supplier;
use App\Forecast;
use App\Part_detail;


class Parts extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

		$forecast = Forecast::select([
			'PartNo',
			'SuppCode',
			'PartName'
		])->where('PartNo','!=', '')
		->distinct()
		->orderBy('SuppCode', 'ASC')
		->get();	

		$arrayPartNo = [];
		$part_id = 0;
		foreach ($forecast as $key => $value) {

			if (!in_array($value['PartNo'], $arrayPartNo )) {
				$arrayPartNo[] = $value['PartNo'];
			}else{
				continue; //jika sudah ada, next
			}

			$supplier_id = Supplier::where('code', '=', $value['SuppCode'] )->first();
			
			if (isset($supplier_id) && $supplier_id != null ) {
				$supplier_id = $supplier_id->id;	
			}else{
				$supplier_id = 1;
			}

			$model = str_random(30);
			$first_value = ceil(rand(0, 99999));
			$total_delivery = $first_value;
			$total_qty = 0;
			$date_of_first_value = '2018-04-01';

			$part = new Part;
			$part->no = $value['PartNo'];
			$part->name = $value['PartName'];
			$part->supplier_id = $supplier_id;
			$part->model = $model;
			$part->first_value = $first_value;
			$part->date_of_first_value = $date_of_first_value;
			$part->save();
			

			$part_detail = new Part_detail;
			$part_id = $part_id + 1;
			$part_detail->part_id = $part_id;
			$part_detail->total_delivery = $total_delivery;
			$part_detail->total_qty = $total_qty;
			$part_detail->trans_date = '2018-03-04';
			$part_detail->save();

		}
		
    }
}
