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
        Schema::create('cutout_material_thickness_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cut_out_id')
                  ->constrained('cut_outs')
                  ->onDelete('cascade'); 
            $table->foreignId('material_type_id')
                  ->constrained('material_types')
                  ->onDelete('cascade');
                  
            $table->string('thickness_value');
            $table->decimal('price_guest', 10, 2)->default(0);
            $table->decimal('price_business', 10, 2)->default(0);            
            $table->boolean('status')->default(1)->comment('1 = Active, 0 = Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cutout_material_thickness_prices');
    }
};
