<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bandwidths', function (Blueprint $table) {
            $table->id();
            $table->integer('bw'); // Bandwidth in Mbps
            $table->integer('price'); // Harga bandwidth
            $table->foreignId('item_id')->constrained('items')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bandwidths');
    }
};