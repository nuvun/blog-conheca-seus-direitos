<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
           $table->string('migration_image_url')->nullable();
           $table->string('migration_slug')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn(['migration_image_url', 'migration_slug']);
        });
    }
};
