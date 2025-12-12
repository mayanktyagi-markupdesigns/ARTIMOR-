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
        Schema::table('cutout_material_thickness_prices', function (Blueprint $table) {
            $table->foreignId('thickness_id')
              ->nullable()
              ->after('material_type_id')
              ->constrained('thicknesses')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cutout_material_thickness_prices', function (Blueprint $table) {
            //
        });
    }
};
