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
        Schema::create('dossier_medical_maladies', function (Blueprint $table) {
            $table->uuid()->primary();
            $table->foreignId('dossier_medical_id')->constrained('dossier_medicals')->onDelete('cascade');
            $table->unsignedBigInteger('maladie_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dossier_medical_maladies');
    }
};
