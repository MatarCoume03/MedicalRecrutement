<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('candidatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('offre_emploi_id')->constrained()->onDelete('cascade');
            $table->text('lettre_motivation')->nullable();
            $table->enum('statut', ['en_attente', 'en_revue', 'entretien', 'accepte', 'rejete'])->default('en_attente');
            $table->text('feedback')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'offre_emploi_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('candidatures');
    }
};