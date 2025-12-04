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
        Schema::create('thicknesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('material_group_id')
                  ->constrained('material_groups')
                  ->onDelete('cascade');

            $table->foreignId('material_type_id')
                  ->constrained('material_types')
                  ->onDelete('cascade');

            $table->string('thickness_value'); // "12mm", "20mm", "30mm", etc.
            $table->boolean('is_massive')->default(false);
            $table->boolean('can_be_laminated')->default(false);
            $table->integer('laminate_min')->nullable();
            $table->integer('laminate_max')->nullable();
            $table->decimal('bussiness_price_m2', 12, 2)->default(0);
            $table->decimal('guest_price_m2', 12, 2)->default(0);
            $table->tinyInteger('status')->default(1)->comment('1 = Active, 0 = Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thicknesses');
    }
};
