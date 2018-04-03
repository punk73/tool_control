<?php

use Illuminate\Database\Seeder;
use App\Supplier;
use App\Tool;

class Tools extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$supplier = Supplier::all();

        for ($i=0; $i < 100 ; $i++) { 
        	$no = str_random(30);
        	$name = str_random(25);
        	$start_value = ceil(rand(0, 99999));
        	$guarantee_shoot = ceil(rand(0, 99999));
        	// $guarantee_remains = rand(0, 99999);
        	// $balance_shoot = ($guarantee_remains - $guarantee_shoot);
        	$delivery_date = date('Y-m-d', mt_rand(1262055681,1262055681) );
			$supplier_id = $supplier[ ceil( rand(0,486 ) )]->id;
        	
        	$tool = new Tool;
        	$tool->no = $no;
        	$tool->name = $name;
        	$tool->start_value = $start_value;
        	$tool->guarantee_shoot = $guarantee_shoot;
        	// $tool->guarantee_remains = $guarantee_remains;
        	// $tool->balance_shoot = $balance_shoot;
        	$tool->delivery_date = $delivery_date;
        	$tool->supplier_id = $supplier_id;
        	$tool->save();
        }

    }
}
