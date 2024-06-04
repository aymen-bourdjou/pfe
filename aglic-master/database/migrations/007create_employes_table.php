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
        Schema::create('employes', function (Blueprint $table) {
            $table->id('id_employe');
            $table->string('nom_employe');
            $table->string('prenom_employe');
            $table->string('username');
            $table->string('password');
            $table->date('date_debut_session')->nullable();
            $table->date('date_fin_session')->nullable();
            $table->string('profil');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employes');
    }
};
