<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('legend');
            $table->string('credit')->nullable();
            $table->string('photographer')->nullable();
            $table->string('local')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
