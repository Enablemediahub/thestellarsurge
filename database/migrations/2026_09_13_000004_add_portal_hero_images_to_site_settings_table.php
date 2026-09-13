<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->string('events_hero_image')->nullable()->after('events_logo_path');
            $table->string('growth_hero_image')->nullable()->after('growth_logo_path');
            $table->string('training_hero_image')->nullable()->after('training_logo_path');
        });
    }

    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table): void {
            $table->dropColumn(['events_hero_image', 'growth_hero_image', 'training_hero_image']);
        });
    }
};