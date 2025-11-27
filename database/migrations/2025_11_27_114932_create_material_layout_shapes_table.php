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
        Schema::create('material_layout_shapes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->foreignId('layout_group_id')
                  ->constrained('material_layout_groups')
                  ->onDelete('cascade');            
            $table->string('image')->nullable();
            $table->boolean('status')->default(1)->comment('1 = Active, 0 = Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_layout_shapes');
    }
};
