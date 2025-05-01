<?php

// database/migrations/2023_01_02_create_recruteur_profils_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('recruteur_profils', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('entreprise')->nullable();
            $table->string('secteur_activite')->nullable();
            $table->string('poste_occupe')->nullable();
            $table->string('site_web')->nullable();
            $table->string('logo')->nullable();
            $table->text('description_entreprise')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recruteur_profils');
    }
};