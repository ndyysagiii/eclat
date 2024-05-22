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
        Schema::create('eclat_result', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_dari');
            $table->date('tanggal_sampai');
            $table->float('min_support');
            $table->float('min_confidance');
            $table->text('itemset');
            $table->float('support');
            $table->float('lift_ratio');
            $table->float('confidence');
            $table->string('result_type'); // e.g., "2-item" or "3-item"
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('eclat_result');
    }
};
