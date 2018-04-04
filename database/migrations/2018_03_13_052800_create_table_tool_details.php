<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableToolDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tool_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tool_id')->unsigned();
              $table->foreign('tool_id')->references('id')->on('tools')->onDelete('cascade'); //add reference
            $table->integer('total_shoot')->default(0);
            $table->float('guarantee_after_forecast')->default(0);
            $table->integer('balance_shoot')->default(0);
            $table->string('forecast_trans_date', 11);
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
        Schema::dropIfExists('tool_details');
    }
}
