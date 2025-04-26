<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vitrins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('subdomain')->unique();
            $table->json('content');
            $table->foreignId('clinic_id')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Add check constraint using raw SQL
        DB::statement('ALTER TABLE vitrins ADD CONSTRAINT check_owner CHECK ((user_id IS NOT NULL AND student_id IS NULL) OR (user_id IS NULL AND student_id IS NOT NULL))');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop check constraint first
        DB::statement('ALTER TABLE vitrins DROP CONSTRAINT IF EXISTS check_owner');
        Schema::dropIfExists('vitrins');
    }
};
