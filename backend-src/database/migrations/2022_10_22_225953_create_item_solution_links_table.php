<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemSolutionLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_solution_links', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->softDeletes();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('url')->nullable();
            $table->integer('item_solution_id')->unsigned();
            $table->string('type');
            $table->foreign('item_solution_id')->references('id')->on('item_solutions')->onDelete('cascade')->onUpdate('cascade');
            });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('item_solution_links');
    }
}
