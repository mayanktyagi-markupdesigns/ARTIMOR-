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
        Schema::create('backsplash_shape_sides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('backsplash_shape_id')
                  ->constrained('backsplash_shapes')
                  ->onDelete('cascade'); 
            $table->string('side_name'); // A, B, C, etc.
            $table->string('label')->nullable(); // UI Label => "Left Side", "Right Side"
            $table->boolean('is_finishable')->default(true);
            $table->tinyInteger('sort_order')->default(1);
            $table->boolean('status')->default(1)->comment('1 = Active, 0 = Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('backsplash_shape_sides');
    }
};
