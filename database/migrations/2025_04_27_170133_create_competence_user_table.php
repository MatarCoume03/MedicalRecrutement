<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('competence_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('competence_id')->constrained()->onDelete('cascade');
            $table->enum('niveau', ['debutant', 'intermediaire', 'avance', 'expert'])->default('intermediaire');
            $table->text('description')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'competence_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('competence_user');
    }
};