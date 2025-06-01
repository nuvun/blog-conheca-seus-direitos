<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\ContentCategory::class, 'category_id')->index()->nullable()->constrained();
        });
    }

    public function down(): void
    {
        Schema::table('videos', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_id');
        });
    }
};
