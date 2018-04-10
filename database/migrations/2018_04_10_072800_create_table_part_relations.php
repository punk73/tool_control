<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablePartRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('part_relations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_part_id')->unsigned();
            // $table->foreign('parent_part_id')->references('id')->on('parts')->onDelete('cascade'); //add reference
            $table->integer('children_part_id')->unsigned();
            // $table->foreign('children_part_id')->references('id')->on('parts')->onDelete('cascade'); //add reference
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
        Schema::dropIfExists('part_relations');

    }
}
