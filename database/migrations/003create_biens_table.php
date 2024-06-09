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
        Schema::create('biens', function (Blueprint $table) {
            $table->id('id_bien');
            $table->string('nom_bien');
            $table->string('prix_d_achat');
            $table->string('barcode')->nullable();
            $table->date('date_achat')->nullable();
            $table->integer('duree_vie')->nullable();
            $table->string('fournisseure')->nullable();
            $table->string('etas')->nullable();
            $table->string('no_serie');
            $table->unsignedBigInteger("id_user_importateure");
            $table->unsignedBigInteger("id_user_updateure")->nullable();
            $table->timestamps();
            $table->foreign('id_user_importateure')->references('id_user')->on('users');
            $table->foreign('id_user_updateure')->references('id_user')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biens');
    }
};
