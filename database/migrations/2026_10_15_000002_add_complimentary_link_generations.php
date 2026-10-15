<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('free_registration_links', function (Blueprint $table) {
            $table->foreignId('root_link_id')
                ->nullable()
                ->after('group_name')
                ->constrained('free_registration_links')
                ->cascadeOnDelete();
            $table->unsignedInteger('generation')->default(1)->after('root_link_id');
        });
    }

    public function down(): void
    {
        Schema::table('free_registration_links', function (Blueprint $table) {
            $table->dropConstrainedForeignId('root_link_id');
            $table->dropColumn('generation');
        });
    }
};
