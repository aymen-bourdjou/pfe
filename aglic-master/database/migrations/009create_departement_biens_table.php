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
        Schema::create('departement_biens', function (Blueprint $table) {
            $table->unsignedBigInteger('id_bien');
            $table->unsignedBigInteger('id_departement');
            $table->string('affecter_a');
            $table->date('date_affectation')->nullable();
            $table->timestamps();
            $table->foreign('id_bien')->references('id_bien')->on('biens');
            $table->foreign('id_departement')->references('id_departement')->on('departements');
            $table->primary(['id_departement', 'id_bien']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departement_biens');
    }
};
