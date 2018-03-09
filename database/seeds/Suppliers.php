<?php

use Illuminate\Database\Seeder;
use App\UserSupp;
use App\Supplier;

class Suppliers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $currentUser = UserSupp::select([
            'SuppName',
            'SuppCode'
        ])->get();

        foreach ($currentUser as $key => $value){ 
            # code...
            $value['SuppName'] = str_replace("  ", "", $value['SuppName']);  
            
            $supplier = new Supplier;
            $supplier->name = $value['SuppName'];
            $supplier->code = $value['SuppCode'];
            $supplier->save();
            
            /*DB::table('suppliers')->insert([
                
                'code'=>$value['SuppCode'] ,
                'name'=> $value['SuppName']
            ]);*/ 
        }
    }
}
