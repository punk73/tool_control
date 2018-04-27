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
        	$username = trim( $value['code'] );
        	$password = $username . '&&';
        	$supplier_id = $value['id'];

       		$user = new User;
       		$user->name = $username;
       		$user->email = $username . '@email.com';
       		$user->password = $password;
       		$user->supplier_id = $supplier_id;
       		$user->save();	
        }

        //admin user
        $user = new User;
        $user->name = 'punk71';
        $user->email = 'teguh@gmail.com';
        $user->password = '123456';
        $user->access_level = 1;
        $user->supplier_id = null;
        $user->save();

        //admin user
        $user = new User;
        $user->name = 'admin';
        $user->email = 'admin@gmail.com';
        $user->password = '123456';
        $user->access_level = 1;
        $user->supplier_id = null;
        $user->save();
          
    }
}
