<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelationshipFieldsToContentCategoriesTable extends Migration
{
    public function up()
    {
        Schema::table('content_categories', function (Blueprint $table) {
            $table->unsignedBigInteger('type_category_id')->nullable();
            $table->foreign('type_category_id', 'type_category_fk_9700837')->references('id')->on('type_categories');
        });
    }
}
