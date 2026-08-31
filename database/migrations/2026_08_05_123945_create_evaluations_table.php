<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formation_id')->constrained('formations')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedTinyInteger('rating')->min(1)->max(5); // Note de 1 à 5 étoiles
            $table->text('comment')->nullable(); // Commentaire textuel
            $table->timestamps();
            
            // Contrainte unique pour empêcher un utilisateur d'évaluer plusieurs fois la même formation
            $table->unique(['formation_id', 'user_id'], 'unique_formation_user_evaluation');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
