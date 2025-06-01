<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('featured_position')->nullable();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->longText('content');
            $table->string('source')->nullable();
            $table->datetime('published_at');
            $table->string('status');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
