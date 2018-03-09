<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePck31 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pck31', function (Blueprint $table) {
            $table->increments('id');
            $table->string('month');
            $table->string('v_code');
            $table->string('part_no');
            $table->string('part_name');
            $table->string('input_date');
            $table->string('do_number');
            $table->string('po_number');
            $table->string('seq');
            $table->integer('qty');
            $table->float('price');
            $table->string('amt');
            $table->string('input_by');
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
        Schema::dropIfExists('pck31');
    }
}
