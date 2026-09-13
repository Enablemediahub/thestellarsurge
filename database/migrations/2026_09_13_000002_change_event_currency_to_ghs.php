<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('events')->where('currency', 'NGN')->update(['currency' => 'GHS']);
        DB::table('payments')->where('currency', 'NGN')->update(['currency' => 'GHS']);
        DB::table('tickets')->where('currency', 'NGN')->update(['currency' => 'GHS']);
    }

    public function down(): void
    {
        DB::table('events')->where('currency', 'GHS')->update(['currency' => 'NGN']);
        DB::table('payments')->where('currency', 'GHS')->update(['currency' => 'NGN']);
        DB::table('tickets')->where('currency', 'GHS')->update(['currency' => 'NGN']);
    }
};
