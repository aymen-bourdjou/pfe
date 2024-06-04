<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipe_employes', function (Blueprint $table) {
            $table->unsignedBigInteger("id_equipe");
            $table->unsignedBigInteger("id_employe");
            $table->date('date_debut')->nullable();
            $table->date('date_fin')->nullable();
            $table->string('role');
            $table->timestamps();
            $table->foreign('id_equipe')->references('id_equipe')->on('equipes');
            $table->foreign('id_employe')->references('id_employe')->on('employes');
            $table->primary(['id_equipe', 'id_employe']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipe_employes');
    }
};
