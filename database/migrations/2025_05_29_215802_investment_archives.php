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
        Schema::create('investment_archives', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // Input parameters
            $table->decimal('capex', 20, 2);
            $table->decimal('opex_percentage', 5, 2);
            $table->decimal('wacc_percentage', 5, 2);
            $table->decimal('bhp_percentage', 5, 2);
            $table->decimal('minimal_irr_percentage', 5, 2);
            $table->decimal('total_revenue', 20, 2);
            
            // Calculated results
            $table->decimal('depreciation', 20, 2);
            $table->decimal('npv', 20, 2);
            $table->decimal('irr', 8, 4); // IRR in percentage
            $table->string('payback_period');
            $table->boolean('is_viable')->default(false);
            
            // Additional info
            $table->timestamp('calculation_date');
            $table->json('cash_flows')->nullable(); // Store cash flows for reference
            $table->text('notes')->nullable();
            
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('calculation_date');
            $table->index('is_viable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('investment_archives');
    }
};