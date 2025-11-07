<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('investment_archive_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('investment_archive_id')->constrained()->cascadeOnDelete();
            $table->foreignId('item_id')->constrained();
            $table->foreignId('bandwidth_id')->constrained();
            $table->integer('quantity')->default(1);
            $table->integer('duration')->comment('In months');
            $table->decimal('price', 20, 2);
            $table->timestamps();

            // Indexes
            $table->index('investment_archive_id');
            $table->index('item_id');
            $table->index('bandwidth_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('investment_archive_items');
    }
};