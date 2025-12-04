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
        Schema::create('finishes', function (Blueprint $table) {
            $table->id();
            $table->string('finish_name');
            $table->foreignId('material_group_id')
                  ->constrained('material_groups')
                  ->onDelete('cascade');

            $table->foreignId('material_type_id')
                    ->constrained('material_types')
                    ->onDelete('cascade');
            
            $table->tinyInteger('status')->default(1)->comment('1 = Active, 0 = Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finishes');
    }
};
