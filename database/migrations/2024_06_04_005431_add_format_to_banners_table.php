<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->string('format')->default(\App\Enums\FormatBannerEnum::FILE->name)->index();
            $table->text('code')->nullable()->after('format');
        });
    }

    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            $table->dropColumn(['format', 'code']);
        });
    }
};
