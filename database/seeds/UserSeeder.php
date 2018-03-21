<?php

use Illuminate\Database\Seeder;
use App\Supplier;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $supplier = Supplier::all();

        foreach ($supplier as $key => $value) {
        	$username = $value['code'];
        	$password = $value['code'] . '&&';
        	$supplier_id = $value['id'];

       		$user = new User;
       		$user->name = $username;
       		$user->email = $username . '@email.com';
       		$user->password = $password;
       		$user->supplier_id = $supplier_id;
       		$user->save();
       		
        }
    }
}
