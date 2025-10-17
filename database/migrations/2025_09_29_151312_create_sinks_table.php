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
        Schema::create('sinks', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->enum('series_type', ['Lorreine r series', 'LORREINE SUPERPLUG SERIES', 'LORREINE BLACK QUARTZ SERIES', 'LORREINE ROYAL SERIES']);            
            $table->decimal('price', 10, 2)->default(0); 
            //Dimensions
            $table->string('internal_dimensions')->nullable(); // e.g., 170x400 mm
            $table->string('external_dimensions')->nullable(); // e.g., 210x440 mm
            $table->integer('depth')->nullable(); // e.g., 180 mm
            $table->integer('radius')->nullable(); // e.g., 10 mm
            $table->boolean('status')->default(1)->comment('1 = Active, 0 = Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sinks');
    }
};
