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
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->foreignId('material_category_id')
                  ->constrained('material_categories')
                  ->onDelete('cascade');
            $table->decimal('price', 10, 2)->default(0); 
            $table->decimal('user_price', 10, 2)->default(0); 
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
        Schema::dropIfExists('materials');
    }
};
