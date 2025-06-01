<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToBannersTable extends Migration
{
    public function up()
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->unsignedBigInteger('type_banner_id')->nullable();
            $table->foreign('type_banner_id', 'type_banner_fk_9700887')->references('id')->on('type_banners');
        });
    }
}
