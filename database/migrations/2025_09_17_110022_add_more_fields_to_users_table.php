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
        Schema::table('users', function (Blueprint $table) {
            $table->string('business_name')->nullable()->after('name');
            $table->string('vat_number')->nullable()->after('business_name');
            $table->string('mobile')->nullable()->after('email');
            $table->string('photo')->nullable()->after('mobile');
            $table->text('address')->nullable()->after('photo');           
            $table->tinyInteger('status')->default(1)->after('address')->comment('0 = InActive, 1 = Active');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['mobile', 'photo', 'address', 'status']);
        });
    }
};
