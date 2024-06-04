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
            $table->text('qr_code')->nullable();
            $table->string('fournisseure')->nullable();
            $table->string('etas')->nullable();
            $table->string('no_serie');
            $table->timestamps();
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
