<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('wallet_address')->nullable()->after('profile_image');
            $table->string('wallet_provider')->nullable()->after('wallet_address'); // metamask | walletconnect
            $table->timestamp('wallet_connected_at')->nullable()->after('wallet_provider');
        });

        Schema::table('marketplace_investments', function (Blueprint $table) {
            $table->string('wallet_address')->nullable()->after('certificate_of_ownership');
            $table->string('tx_hash')->nullable()->after('wallet_address');
            $table->index('tx_hash');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['wallet_address', 'wallet_provider', 'wallet_connected_at']);
        });
        Schema::table('marketplace_investments', function (Blueprint $table) {
            $table->dropIndex(['tx_hash']);
            $table->dropColumn(['wallet_address', 'tx_hash']);
        });
    }
};
