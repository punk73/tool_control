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
        $this->call(Parts::class);
        $this->call(Tools::class);
        $this->call(toolpartSeeders::class);
        $this->call(UserSeeder::class);
        $this->call(PCK31Seeder::class);
        
    }
}
