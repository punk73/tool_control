<?php

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(Suppliers::class);
        // $this->call(Parts::class); //seeder tool masuk kesini sekalian
        // $this->call(Tools::class); //udah sekalian di parts
        // $this->call(toolpartSeeders::class); //udah sekalian di parts
        $this->call(UserSeeder::class);
        // $this->call(PCK31Seeder::class);
        // $this->call(ToolDetailSeeder::class);
        
        
    }
}
