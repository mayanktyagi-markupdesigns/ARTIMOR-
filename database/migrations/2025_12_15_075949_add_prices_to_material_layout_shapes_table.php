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
        Schema::table('material_layout_shapes', function (Blueprint $table) {
            $table->decimal('price_guest', 10, 2)->default(0)->after('status');
            $table->decimal('price_business', 10, 2)->default(0)->after('price_guest');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('material_layout_shapes', function (Blueprint $table) {
           $table->dropColumn(['price_guest', 'price_business']);
        });
    }
};
