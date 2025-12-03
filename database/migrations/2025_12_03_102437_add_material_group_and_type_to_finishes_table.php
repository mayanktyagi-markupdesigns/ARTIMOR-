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
        Schema::table('finishes', function (Blueprint $table) {
            $table->foreignId('material_group_id')
              ->after('color_id')
              ->constrained('material_groups')
              ->onDelete('cascade');

        $table->foreignId('material_type_id')
              ->after('material_group_id')
              ->constrained('material_types')
              ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('finishes', function (Blueprint $table) {
        $table->dropForeign(['material_group_id']);
        $table->dropForeign(['material_type_id']);

        // Drop columns
        $table->dropColumn(['material_group_id', 'material_type_id']);
        });
    }
};
