<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_verified')->default(false)->after('phone_verified_at');
        });

        DB::table('users')
            ->whereNotNull('email_verified_at')
            ->orWhereNotNull('phone_verified_at')
            ->update(['is_verified' => true]);

        DB::table('users')
            ->where(function ($q) {
                $q->where('is_google', true)->orWhere('is_facebook', true)->orWhere('is_apple', true);
            })
            ->update(['is_verified' => true]);
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_verified');
        });
    }
};
