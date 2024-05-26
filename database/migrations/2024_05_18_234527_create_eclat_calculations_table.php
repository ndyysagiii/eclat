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
        Schema::create('eclat_calculations', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_dari');
            $table->date('tanggal_sampai');
            $table->decimal('min_support', 5, 2);
            $table->decimal('min_confidance', 5, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eclat_calculations');
    }
};
