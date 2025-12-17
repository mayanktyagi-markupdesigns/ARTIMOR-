<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('backsplash_prices', function (Blueprint $table) {
            // Add thickness_id after material_type_id
            $table->foreignId('thickness_id')
                  ->nullable()
                  ->after('material_type_id')
                  ->constrained('thicknesses')
                  ->cascadeOnDelete(); // optional: delete price if thickness deleted
        });
    }

    public function down(): void
    {
        Schema::table('backsplash_prices', function (Blueprint $table) {
            $table->dropForeign(['thickness_id']);
            $table->dropColumn('thickness_id');
        });
    }
};