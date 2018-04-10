<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePartDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('part_id')->unsigned();
                $table->foreign('part_id')->references('id')->on('parts')->onDelete('cascade'); //add reference
            $table->integer('total_delivery', 0);
            $table->integer('total_qty', 0);
            $table->string('trans_date', 11);
            $table->timestamps();
        });
            
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('part_details');
    }
}
