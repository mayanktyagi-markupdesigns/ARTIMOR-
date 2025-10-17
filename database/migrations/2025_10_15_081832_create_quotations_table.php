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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id')->nullable();
            $table->unsignedBigInteger('material_type_id')->nullable();
            $table->unsignedBigInteger('layout_id')->nullable();
            $table->json('dimensions')->nullable(); // Store as JSON, e.g., {"blad1": {"width": "100", "height": "200"}}
            $table->unsignedBigInteger('edge_id')->nullable();
            $table->integer('edge_thickness')->nullable();
            $table->json('edge_selected_edges')->nullable(); // Store as JSON array
            $table->unsignedBigInteger('back_wall_id')->nullable();
            $table->integer('back_wall_thickness')->nullable();
            $table->json('back_wall_selected_edges')->nullable(); // Store as JSON array
            $table->unsignedBigInteger('sink_id')->nullable();
            $table->string('sink_cutout')->nullable();
            $table->integer('sink_number')->nullable();
            $table->unsignedBigInteger('cutout_id')->nullable();
            $table->string('cutout_recess_type')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->string('email');
            $table->string('delivery_option');
            $table->string('measurement_time');
            $table->string('promo_code')->nullable();
            $table->decimal('total_price', 10, 2);            

            // Foreign keys (optional, assuming cascade on delete)
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('set null');
            $table->foreign('material_type_id')->references('id')->on('material_types')->onDelete('set null');
            $table->foreign('layout_id')->references('id')->on('material_layouts')->onDelete('set null');
            $table->foreign('edge_id')->references('id')->on('material_edges')->onDelete('set null');
            $table->foreign('back_wall_id')->references('id')->on('back_walls')->onDelete('set null');
            $table->foreign('sink_id')->references('id')->on('sinks')->onDelete('set null');
            $table->foreign('cutout_id')->references('id')->on('cut_outs')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
