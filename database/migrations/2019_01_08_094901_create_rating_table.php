<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rating', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('from_userid')->unsigned();
            $table->foreign('from_userid')->references('id')->on('users');
            $table->integer('to_userid')->unsigned();
            $table->foreign('to_userid')->references('id')->on('users');
            $table->integer('value_for_money')->unsigned()->nullable();
            $table->integer('quality_of_work')->unsigned()->nullable();
            $table->integer('relation_with_customer')->unsigned()->nullable();
            $table->integer('performance')->unsigned()->nullable();
            $table->integer('total')->unsigned()->nullable();
            $table->text('review')->nullable();
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
        Schema::dropIfExists('rating');
    }
}
