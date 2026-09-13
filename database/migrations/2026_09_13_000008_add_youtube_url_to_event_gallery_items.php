<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_gallery_items', function (Blueprint $table): void {
            $table->text('image_path')->nullable()->change();
            $table->string('youtube_url')->nullable()->after('image_path');
        });
    }

    public function down(): void
    {
        Schema::table('event_gallery_items', function (Blueprint $table): void {
            $table->dropColumn('youtube_url');
            $table->text('image_path')->nullable(false)->change();
        });
    }
};
