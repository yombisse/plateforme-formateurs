<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('formations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('slug')->unique();
            $table->string('category')->nullable();
            $table->string('mode')->nullable();
            $table->string('level')->nullable();
            $table->string('title');
            $table->string('trainer_name')->nullable();
            $table->text('short_description')->nullable();
            $table->text('full_description')->nullable();
            $table->enum('status', ['Brouillon', 'Actif', 'Fermé', 'Terminé'])->default('Brouillon');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('location')->nullable();
            $table->string('duration')->nullable();
            $table->unsignedInteger('max_places')->default(0);
            $table->unsignedInteger('price')->default(0);
            $table->string('currency')->default('FCFA');
            $table->string('delivery_link')->nullable();
            $table->string('image')->nullable();
            $table->json('objectives')->nullable();
            $table->json('modules')->nullable();
            $table->json('learning_points')->nullable();
            $table->json('practical_info')->nullable();
            $table->text('about')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('formations');
    }
};
