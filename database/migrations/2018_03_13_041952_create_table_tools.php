<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableTools extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tools', function (Blueprint $table) {
            $table->increments('id');
            $table->string('no')->unique();
            $table->string('name');
            $table->string('no_of_tooling')->default('TL-01');
            $table->integer('total_shoot')->default(0);
            $table->integer('guarantee_shoot')->default(0);
            $table->float('guarantee_remains')->default(0);
            $table->date('delivery_date'); //static
            $table->integer('balance_shoot')->default(0); //sisanya berapa. bakal editable
            $table->integer('supplier_id');
            $table->integer('is_deleted')->default(0);
            $table->softDeletes();
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
        Schema::dropIfExists('tools');
    }
}
