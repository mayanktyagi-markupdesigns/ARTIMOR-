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
        Schema::create('cut_outs_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cut_out_id')->constrained('cut_outs')->onDelete('cascade');
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
        Schema::dropIfExists('cut_outs_images');
    }
};
