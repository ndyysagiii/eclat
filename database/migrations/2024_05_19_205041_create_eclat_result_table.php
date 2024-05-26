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
        Schema::create('eclat_results', function (Blueprint $table) {
            $table->id();
            $table->string('itemset');
            $table->decimal('support', 5, 2);
            $table->decimal('confidence', 5, 2);
            $table->string('result_type');
            $table->string('keterangan');
            $table->decimal('lift_ratio', 5, 2);
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
