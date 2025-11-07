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
        Schema::create('master_products', function (Blueprint $table) {
            $table->id();
            $table->string('name');

            // Foreign keys to selected items
            $table->unsignedBigInteger('material_id');
            $table->unsignedBigInteger('material_type_id');
            $table->unsignedBigInteger('material_layout_id');
            $table->unsignedBigInteger('material_edge_id');
            $table->unsignedBigInteger('back_wall_id');
            $table->unsignedBigInteger('sink_id');
            $table->unsignedBigInteger('cut_outs_id');
            $table->unsignedBigInteger('color_id');

            // Foreign key constraints
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
            $table->foreign('material_type_id')->references('id')->on('material_types')->onDelete('cascade');
            $table->foreign('material_layout_id')->references('id')->on('material_layouts')->onDelete('cascade');
            $table->foreign('material_edge_id')->references('id')->on('material_edges')->onDelete('cascade'); 
            $table->foreign('back_wall_id')->references('id')->on('back_walls')->onDelete('cascade'); 
            $table->foreign('sink_id')->references('id')->on('sinks')->onDelete('cascade'); 
            $table->foreign('cut_outs_id')->references('id')->on('cut_outs')->onDelete('cascade'); 
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('cascade'); 
            $table->boolean('status')->default(1)->comment('1 = Active, 0 = Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_products');
    }
};
