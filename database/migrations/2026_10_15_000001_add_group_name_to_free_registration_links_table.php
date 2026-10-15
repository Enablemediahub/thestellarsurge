<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('free_registration_links', function (Blueprint $table) {
            $table->string('group_name')->default('General')->after('created_by');
        });
    }

    public function down(): void
    {
        Schema::table('free_registration_links', function (Blueprint $table) {
            $table->dropColumn('group_name');
        });
    }
};
