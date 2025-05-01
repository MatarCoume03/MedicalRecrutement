<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // CV, Lettre de motivation, Diplôme, Certificat, etc.
            $table->string('nom_fichier');
            $table->string('chemin');
            $table->string('mime_type');
            $table->unsignedBigInteger('taille');
            $table->boolean('est_public')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('documents');
    }
};