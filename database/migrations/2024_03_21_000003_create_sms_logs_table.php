<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sms_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vitrin_id')->constrained()->onDelete('cascade');
            $table->string('phone');
            $table->text('message');
            $table->timestamp('sent_at');
            $table->timestamps();
            
            // Index for efficient querying
            $table->index(['vitrin_id', 'sent_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sms_logs');
    }
}; 