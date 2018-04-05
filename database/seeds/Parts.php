<?php

use Illuminate\Database\Seeder;
use App\Part;
use App\Supplier;
use App\Forecast;


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


			$part = new Part;
			$part->no = $value['PartNo'];
			$part->name = $value['PartName'];
			$part->supplier_id = $supplier_id;
			$part->model = $model;
			$part->first_value = $first_value;
			$part->total_delivery = $total_delivery;
			$part->total_qty = $total_qty;
			echo $key;
			echo '.';
			$part->save();

		}
		
    }
}
