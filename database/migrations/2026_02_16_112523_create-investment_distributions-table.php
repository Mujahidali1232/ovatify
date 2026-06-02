<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Investment Distributions Table
        Schema::create('investment_distributions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('marketplace_investment_id');
            $table->decimal('distribution_amount', 10, 2);
            $table->string('distribution_type')->default('dividend'); // dividend, withdrawal, bonus
            $table->string('status')->default('completed'); // completed, pending, failed
            $table->text('notes')->nullable();
            $table->timestamp('distribution_date');
            $table->timestamps();

            $table->foreign('marketplace_investment_id')
                ->references('id')
                ->on('marketplace_investments')
                ->onDelete('cascade');

            $table->index('marketplace_investment_id');
            $table->index('distribution_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('investment_distributions');
    }
};
