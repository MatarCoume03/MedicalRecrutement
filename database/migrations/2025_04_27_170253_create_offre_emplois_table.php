<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('offre_emplois', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('titre');
            $table->text('description');
            $table->string('specialite_requise');
            $table->integer('annees_experience_requises')->nullable();
            $table->string('niveau_etude_requis')->nullable();
            $table->string('type_contrat');
            $table->string('localisation');
            $table->decimal('salaire_min', 10, 2)->nullable();
            $table->decimal('salaire_max', 10, 2)->nullable();
            $table->date('date_limite');
            $table->enum('statut', ['en_attente', 'approuve', 'rejete', 'expire'])->default('en_attente');
            $table->boolean('is_urgent')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('offre_emplois');
    }
};