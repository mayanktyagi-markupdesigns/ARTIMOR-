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
        Schema::table('material_color_edge_exceptions', function (Blueprint $table) {
            $table->decimal('override_guest_price_per_lm', 12, 2)
                  ->nullable()
                  ->after('override_price_per_lm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('material_color_edge_exceptions', function (Blueprint $table) {
            $table->dropColumn('override_price_per_lm');
        });
    }
};