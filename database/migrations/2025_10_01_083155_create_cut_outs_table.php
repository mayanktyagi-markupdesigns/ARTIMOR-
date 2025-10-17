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
        Schema::create('cut_outs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->decimal('price', 10, 2)->default(0); 
            $table->enum('series_type', ['Lorreine r series', 'LORREINE SUPERPLUG SERIES', 'LORREINE BLACK QUARTZ SERIES', 'LORREINE ROYAL SERIES']); 
            $table->text('description')->nullable();            
            $table->boolean('status')->default(1)->comment('1 = Active, 0 = Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cut_outs');
    }
};
