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
        Schema::create('backsplash_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_type_id')
                  ->constrained('material_types')
                  ->onDelete('cascade'); 

            // Pricing (GUEST)
            $table->decimal('price_lm_guest', 12, 2)->default(0);
            $table->decimal('finished_side_price_lm_guest', 12, 2)->default(0);
            // Pricing (BUSINESS USERS)
            $table->decimal('price_lm_business', 12, 2)->default(0);
            $table->decimal('finished_side_price_lm_business', 12, 2)->default(0);
            // Optional height constraints
            $table->integer('min_height_mm')->nullable();
            $table->integer('max_height_mm')->nullable();
            $table->boolean('status')->default(1)->comment('1 = Active, 0 = Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backsplash_prices');
    }
};
