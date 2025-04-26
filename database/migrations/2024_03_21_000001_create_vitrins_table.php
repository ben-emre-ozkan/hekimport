<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vitrins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('subdomain')->unique();
            $table->json('content');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Add FULLTEXT index for search
        DB::statement('ALTER TABLE dev_vitrins ADD FULLTEXT search_index(subdomain, content)');
    }

    public function down(): void
    {
        Schema::dropIfExists('vitrins');
    }
}; 