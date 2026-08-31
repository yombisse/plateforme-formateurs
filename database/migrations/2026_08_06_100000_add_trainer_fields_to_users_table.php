<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Informations de base du formateur
            $table->string('specialty')->nullable();
            $table->string('location')->nullable();
            $table->string('phone')->nullable();
            $table->text('bio')->nullable();
            
            // Photos
            $table->string('profile_photo')->nullable();
            $table->string('hero_image')->nullable();
            
            // Réseaux sociaux
            $table->string('instagram_url')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('website_url')->nullable();
            
            // Tags/Compétences
            $table->json('tags')->nullable();
            
            // Statistiques
            $table->integer('formations_count')->default(0);
            $table->integer('students_count')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'specialty',
                'location', 
                'phone',
                'bio',
                'profile_photo',
                'hero_image',
                'instagram_url',
                'linkedin_url',
                'website_url',
                'tags',
                'formations_count',
                'students_count',
            ]);
        });
    }
};