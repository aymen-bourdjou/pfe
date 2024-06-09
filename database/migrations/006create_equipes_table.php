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
        Schema::create('equipes', function (Blueprint $table) {
            $table->id('id_equipe');
            $table->unsignedBigInteger('id_comptage')->nullable();
            $table->string('nom_equipe');
            $table->unsignedBigInteger("id_user_createure");
            $table->unsignedBigInteger("id_user_updateure")->nullable();
            $table->timestamps();
            $table->foreign('id_user_createure')->references('id_user')->on('users');
            $table->foreign('id_user_updateure')->references('id_user')->on('users');
            $table->foreign('id_comptage')->references('id_comptage')->on('comptages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipes');
    }
};
