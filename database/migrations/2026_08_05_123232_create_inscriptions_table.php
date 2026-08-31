<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('formation_id')->constrained('formations')->cascadeOnDelete();
            $table->string('nom_complet');
            $table->string('telephone');
            $table->string('email')->nullable();
            $table->enum('statut_paiement', ['en_attente', 'confirme', 'annule'])->default('en_attente');
            $table->string('mode_paiement')->nullable(); // Wave / Orange Money / Virement
            
            // Champs pour la gestion des inscriptions
            $table->enum('statut_inscription', ['en_attente', 'valide', 'rejete'])->default('en_attente');
            $table->text('motif_rejet')->nullable();
            $table->foreignId('rejet_par')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('valide_par')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('date_validation')->nullable();
            $table->timestamp('date_rejet')->nullable();
            
            $table->timestamps();
            
            // Contrainte unique composite pour empêcher les doublons
            $table->unique(['formation_id', 'telephone'], 'unique_formation_telephone');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscriptions');
    }
};
