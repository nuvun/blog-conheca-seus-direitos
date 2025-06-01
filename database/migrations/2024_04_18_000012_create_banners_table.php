<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->string('link')->nullable();
            $table->integer('position');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
