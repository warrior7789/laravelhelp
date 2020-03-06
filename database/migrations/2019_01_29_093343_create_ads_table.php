<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->increments('id');
            $table->string('pagename', 300);
            $table->string('title', 300)->nullable();
            $table->string('link', 300)->nullable();
            $table->string('image', 300)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('isgoogle')->default(0)->unsigned();
            $table->tinyInteger('status')->default(1)->unsigned();
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
        Schema::dropIfExists('ads');
    }
}
