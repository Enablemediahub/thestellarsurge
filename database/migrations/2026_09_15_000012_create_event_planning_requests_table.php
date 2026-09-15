<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('event_planning_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('event_type');
            $table->string('consultation_preference');
            $table->date('event_date')->nullable();
            $table->unsignedInteger('guest_count')->nullable();
            $table->string('budget')->nullable();
            $table->text('message');
            $table->string('status')->default('new');
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('event_planning_requests');
    }
};
