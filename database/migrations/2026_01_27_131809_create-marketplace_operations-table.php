<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Marketplace Transactions Table
        Schema::create('marketplace_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Buyer
            $table->unsignedBigInteger('seller_id'); // Seller
            $table->unsignedBigInteger('marketplace_asset_id');
            $table->enum('transaction_type', ['purchase', 'license', 'license_renewal', 'investment']);
            $table->string('transaction_reference')->unique();
            $table->decimal('amount', 12, 2);
            $table->decimal('seller_amount', 12, 2);
            $table->decimal('platform_fee', 12, 2);
            $table->enum('status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->json('payment_gateway_response')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('seller_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('marketplace_asset_id')->references('id')->on('marketplace_assets')->onDelete('cascade');

            $table->index('user_id');
            $table->index('seller_id');
            $table->index('status');
            $table->index('transaction_type');
            $table->index('created_at');
        });

        // Marketplace Purchases Table
        Schema::create('marketplace_purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('marketplace_asset_id');
            $table->unsignedBigInteger('transaction_id');
            $table->decimal('purchase_price', 12, 2);
            $table->string('payment_method');
            $table->enum('payment_status', ['pending', 'completed', 'failed', 'refunded'])->default('pending');
            $table->string('access_token')->unique();
            $table->integer('download_count')->default(0);
            $table->timestamp('last_downloaded_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('marketplace_asset_id')->references('id')->on('marketplace_assets')->onDelete('cascade');
            $table->foreign('transaction_id')->references('id')->on('marketplace_transactions')->onDelete('cascade');

            $table->index('user_id');
            $table->index('marketplace_asset_id');
            $table->index('payment_status');
            $table->index('created_at');
        });

        // Marketplace Licenses Table
        Schema::create('marketplace_licenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('marketplace_asset_id');
            $table->unsignedBigInteger('transaction_id');
            $table->string('license_key')->unique();
            $table->string('license_type');
            $table->timestamp('licensed_from');
            $table->timestamp('licensed_until')->nullable();
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending');
            $table->decimal('license_price', 12, 2);
            $table->string('payment_method');
            $table->integer('usage_count')->default(0);
            $table->integer('max_usage')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('marketplace_asset_id')->references('id')->on('marketplace_assets')->onDelete('cascade');
            $table->foreign('transaction_id')->references('id')->on('marketplace_transactions')->onDelete('cascade');

            $table->index('user_id');
            $table->index('marketplace_asset_id');
            $table->index('is_active');
            $table->index('licensed_until');
        });

        // Marketplace Investments Table
        Schema::create('marketplace_investments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('marketplace_asset_id');
            $table->unsignedBigInteger('transaction_id');
            $table->integer('blocks_purchased');
            $table->decimal('investment_amount', 14, 2);
            $table->decimal('price_per_block', 12, 2);
            $table->decimal('ownership_percentage', 5, 2);
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending');
            $table->string('payment_method');
            $table->string('certificate_of_ownership')->unique()->nullable();
            $table->decimal('expected_roi', 14, 2);
            $table->decimal('total_earned', 14, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('marketplace_asset_id')->references('id')->on('marketplace_assets')->onDelete('cascade');
            $table->foreign('transaction_id')->references('id')->on('marketplace_transactions')->onDelete('cascade');

            $table->index('user_id');
            $table->index('marketplace_asset_id');
            $table->index('is_active');
            $table->index('created_at');
        });

        
    }

    public function down(): void
    {
        
        Schema::dropIfExists('marketplace_investments');
        Schema::dropIfExists('marketplace_licenses');
        Schema::dropIfExists('marketplace_purchases');
        Schema::dropIfExists('marketplace_transactions');
    }
};