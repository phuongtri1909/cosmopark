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
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45);
            $table->string('page_url');
            $table->string('page_name')->nullable();
            $table->string('user_agent')->nullable();
            $table->string('referer')->nullable();
            $table->integer('view_count')->default(1);
            $table->date('view_date');
            $table->timestamps();
            
            // Indexes for performance
            $table->index(['ip_address', 'page_url', 'view_date']);
            $table->index(['page_name', 'view_date']);
            $table->index('view_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
};
