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
            // STEP 1: Add column after id
            Schema::table('backsplash_prices', function (Blueprint $table) {
                $table->unsignedBigInteger('backsplash_shape_id')->nullable()->after('id');
            });

            // STEP 2: Add foreign key constraint
            Schema::table('backsplash_prices', function (Blueprint $table) {
                $table->foreign('backsplash_shape_id')
                    ->references('id')
                    ->on('backsplash_shapes')
                    ->onDelete('cascade');
            });
        }

        public function down(): void
        {
            Schema::table('backsplash_prices', function (Blueprint $table) {
                $table->dropForeign(['backsplash_shape_id']);
                $table->dropColumn('backsplash_shape_id');
            });
        }

    };
