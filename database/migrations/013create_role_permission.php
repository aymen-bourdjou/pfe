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
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger("id_role");
            $table->unsignedBigInteger("id_permission");
            $table->date('date_debut')->nullable();
            $table->foreign('id_role')->references('id_role')->on('roles');
            $table->foreign('id_permission')->references('id_permission')->on('permissions');
            $table->primary(['id_role', 'id_permission']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permission');
    }
};
