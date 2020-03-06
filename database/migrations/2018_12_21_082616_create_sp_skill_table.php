<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpSkillTable extends Migration
{
    /**
     * Run the migrations.
     *  description     text    
    price_per_hour  int(11)
    price_per_day   int(11)
    show_price      varchar(10) hour/day
    offer_discount  int(3) (percentage)
    offer_desc      text
    offer_img       varchar(255)
    offer_start_date int(11)
    offer_end_date   int(11)
    currency        int(11)
    status          tiny_int(1)
     * @return void
     */
    public function up()
    {
        Schema::create('sp_skill', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('skill_id')->unsigned();
            $table->foreign('skill_id')->references('id')->on('skill');
            $table->integer('currency_id')->unsigned();
            $table->foreign('currency_id')->references('id')->on('currency');
            $table->text('description')->nullable();
            $table->decimal('price_per_hour', 8, 2)->default(0.00);
            $table->decimal('price_per_day', 8, 2)->default(0.00);
            $table->string('show_price', 10)->default('hour');
            
            $table->integer('offer_discount')->unsigned()->nullable();
            $table->text('offer_desc')->nullable();
            $table->string('offer_img', 255)->nullable();
            $table->integer('offer_start_date')->unsigned()->nullable();
            $table->integer('offer_end_date')->unsigned()->nullable();            
            

            $table->tinyInteger('status')->default(1)->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sp_skill');
    }
}
