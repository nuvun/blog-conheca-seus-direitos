<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Image::class)
                ->index()
                ->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropConstrainedForeignIdFor(\App\Models\Image::class);
        });
    }

};
