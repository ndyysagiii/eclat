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
        Schema::table('eclat_results', function (Blueprint $table) {
            $table->foreignId('eclat_calculation_id')->constrained('eclat_calculations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('eclat_result', function (Blueprint $table) {
            $table->dropForeign(['eclat_calculation_id']);
            $table->dropColumn('eclat_calculation_id');
        });
    }
};
