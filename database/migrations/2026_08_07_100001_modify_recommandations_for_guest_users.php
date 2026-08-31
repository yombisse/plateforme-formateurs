<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('recommandations', function (Blueprint $table) {
            // Rendre user_id nullable
            $table->foreignId('user_id')->nullable()->change();
            
            // Ajouter des champs pour les utilisateurs non authentifiés
            $table->string('guest_name')->nullable();
            $table->string('guest_email')->nullable();
            $table->string('guest_phone')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('recommandations', function (Blueprint $table) {
            $table->dropColumn(['guest_name', 'guest_email', 'guest_phone']);
            $table->foreignId('user_id')->nullable(false)->change();
        });
    }
};