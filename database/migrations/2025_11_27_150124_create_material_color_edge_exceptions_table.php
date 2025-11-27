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
        Schema::create('material_color_edge_exceptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('color_id')
                  ->constrained('colors')
                  ->onDelete('cascade');

            $table->foreignId('edge_profile_id')
                  ->constrained('edge_profiles')
                  ->onDelete('cascade');

            $table->foreignId('thickness_id')
                  ->constrained('thicknesses')
                  ->onDelete('cascade');
            $table->boolean('is_allowed')->default(true);
             $table->boolean('status')->default(1)->comment('1 = Active, 0 = Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_color_edge_exceptions');
    }
};
