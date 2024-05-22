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
            $table->unsignedBigInteger('eclat_result_id');
            $table->unsignedBigInteger('obat_id');
            $table->foreign('eclat_result_id')->references('id')->on('eclat_result')->onDelete('cascade');
            $table->foreign('obat_id')->references('id')->on('obat')->onDelete('cascade');
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
