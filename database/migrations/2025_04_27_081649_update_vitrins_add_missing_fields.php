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
        Schema::table('vitrins', function (Blueprint $table) {
            $table->string('subdomain')->unique()->nullable()->after('student_id'); // Assuming vitrin URL structure like subdomain.hekimport.com
            $table->json('content')->nullable()->after('subdomain'); // General purpose JSON for flexible fields like bio, etc.
            $table->json('working_hours')->nullable()->after('content'); // Çalışma saatleri (Örn: Pazartesi: 9-5)
            $table->json('services')->nullable()->after('working_hours'); // Sunulan hizmetler listesi
            $table->json('social_media')->nullable()->after('services'); // Sosyal medya linkleri (Instagram, LinkedIn vb.)
            $table->json('contact_info')->nullable()->after('social_media'); // İletişim bilgileri (Telefon, E-posta)
            $table->string('custom_slug')->unique()->nullable()->after('contact_info'); // If a different slug is needed besides subdomain
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vitrins', function (Blueprint $table) {
            $table->dropColumn([
                'subdomain',
                'content',
                'working_hours',
                'services',
                'social_media',
                'contact_info',
                'custom_slug'
            ]);
        });
    }
};
