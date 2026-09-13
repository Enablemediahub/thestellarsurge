<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_name')->default('Stellar Surge');
            $table->string('logo_path')->nullable();
            $table->string('favicon_path')->nullable();
            $table->json('hero_slides')->nullable();
            $table->string('events_logo_path')->nullable();
            $table->string('growth_logo_path')->nullable();
            $table->string('training_logo_path')->nullable();
            $table->string('events_color')->default('#E17B7C');
            $table->string('growth_color')->default('#F9AD2D');
            $table->string('training_color')->default('#159D99');
            $table->string('plum_color')->default('#32152F');
            $table->string('gold_color')->default('#C8A46A');
            $table->string('ivory_color')->default('#F7F2E9');
            $table->string('contact_email')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->json('social_links')->nullable();
            $table->text('footer_credit')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
