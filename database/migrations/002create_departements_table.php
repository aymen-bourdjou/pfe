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
        Schema::create('departements', function (Blueprint $table) {
            $table->id('id_departement');
            $table->unsignedBigInteger('id_zone');
            $table->string ('nom_departement');
            $table->unsignedBigInteger("id_user_createure");
            $table->unsignedBigInteger("id_user_updateure")->nullable();
            $table->timestamps(); 
            $table->foreign('id_user_createure')->references('id_user')->on('users');
            $table->foreign('id_user_updateure')->references('id_user')->on('users');
            $table->foreign('id_zone')->references('id_zone')->on('zones');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departements');
    }
};
