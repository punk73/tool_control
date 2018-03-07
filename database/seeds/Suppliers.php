<?php

use Illuminate\Database\Seeder;
use App\UserSupp;

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
            DB::table('suppliers')->insert([
                
                'code'=>$value['SuppCode'] ,
                'name'=> $value['SuppName']
            ]); 
        }
    }
}
