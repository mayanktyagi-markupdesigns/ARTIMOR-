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
        Schema::create('edge_profile_thickness_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('edge_profile_id')
                  ->constrained('edge_profiles')
                  ->onDelete('cascade');

            $table->foreignId('material_type_id')
                  ->constrained('material_types')
                  ->onDelete('cascade'); 

            $table->foreignId('thickness_id')
                  ->constrained('thicknesses')
                  ->onDelete('cascade');

            $table->boolean('is_allowed')->default(true);
            $table->decimal('price_per_lm_guest', 12, 2)->default(0);
            $table->decimal('price_per_lm_business', 12, 2)->default(0);
            $table->boolean('status')->default(1)->comment('1 = Active, 0 = Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edge_profile_thickness_rules');
    }
};
