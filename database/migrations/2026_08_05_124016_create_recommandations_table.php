<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('recommandations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete(); // L'utilisateur qui recommande
            $table->foreignId('trainer_id')->constrained('users')->cascadeOnDelete(); // Le formateur recommandé
            $table->text('comment')->nullable(); // Commentaire sur la recommandation
            $table->boolean('is_public')->default(true); // Si la recommandation est publique
            $table->timestamps();
            
            // Contrainte unique pour empêcher un utilisateur de recommander plusieurs fois le même formateur
            $table->unique(['user_id', 'trainer_id'], 'unique_user_trainer_recommendation');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('recommandations');
    }
};
