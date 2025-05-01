<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('candidat_profils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('date_naissance')->nullable();
            $table->enum('genre', ['homme', 'femme', 'autre'])->nullable();
            $table->string('nationalite')->nullable();
            $table->string('ville')->nullable();
            $table->text('bio')->nullable();
            $table->string('specialite_medicale')->nullable();
            $table->integer('annees_experience')->nullable();
            $table->string('niveau_etude')->nullable();
            $table->json('langues')->nullable(); // Stockage des langues parlées
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('candidat_profils');
    }
};