<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string('discount_mode', 20)->default('general')->after('discount_price');
            $table->unsignedInteger('link_discount_price')->nullable()->after('discount_mode');
        });

        Schema::create('event_discount_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->string('label');
            $table->char('token_hash', 64)->unique();
            $table->text('encrypted_token')->nullable();
            $table->unsignedInteger('usage_limit')->nullable();
            $table->unsignedInteger('usage_count')->default(0);
            $table->dateTime('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_discount_links');

        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn(['discount_mode', 'link_discount_price']);
        });
    }
};
