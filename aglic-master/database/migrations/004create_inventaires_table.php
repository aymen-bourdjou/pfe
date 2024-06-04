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
        Schema::create('inventaires', function (Blueprint $table) {
            $table->id('id_inventaire');
            $table->string('nom_inventaire');
            $table->enum('etas', ['en attente de lancement', 'en cours', 'annulé','cloturé'])->default('en attente de lancement');
            $table->string('observation')->nullable();
            $table->date('date_creation')->nullable();
            $table->date('date_debut')->nullable(); 
            $table->date('date_fin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaires');
    }
};
