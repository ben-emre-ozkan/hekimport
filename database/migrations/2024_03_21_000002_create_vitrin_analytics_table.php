<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vitrin_analytics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vitrin_id')->constrained()->onDelete('cascade');
            $table->string('metric'); // visits, clicks, impressions
            $table->integer('value');
            $table->date('date');
            $table->timestamps();
            
            // Composite index for efficient querying
            $table->index(['vitrin_id', 'metric', 'date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vitrin_analytics');
    }
}; 