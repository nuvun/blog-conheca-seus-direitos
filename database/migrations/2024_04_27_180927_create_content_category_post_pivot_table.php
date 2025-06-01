<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('content_category_post', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Post::class, 'post_id')->index()->constrained();
            $table->foreignIdFor(\App\Models\ContentCategory::class, 'content_category_id')->index()->constrained();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('content_category_post');
    }

};
