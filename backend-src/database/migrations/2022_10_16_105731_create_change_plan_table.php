<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateChangePlanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('change_plans', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->text('description')->nullable();
            $table->integer('change_request_id')->unsigned();
            $table->string('status');
            $table->foreign('change_request_id')->references('id')->on('change_requests')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('change_plans');
    }
}
