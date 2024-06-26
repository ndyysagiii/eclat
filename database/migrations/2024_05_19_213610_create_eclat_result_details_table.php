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
        Schema::create('eclat_result_details', function (Blueprint $table) {
            // $table->id();
            $table->foreignId('eclat_calculation_id')->constrained('eclat_calculations')->onDelete('cascade');
            $table->foreignId('eclat_result_id')->constrained('eclat_results')->onDelete('cascade');
            $table->unsignedBigInteger('obat_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eclat_result_details');
    }
};
