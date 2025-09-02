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
        Schema::create('intro_location_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intro_location_id')->constrained('intro_locations')->onDelete('cascade');
            $table->json('label');
            $table->json('value');
            $table->json('unit')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['intro_location_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intro_location_stats');
    }
}; 