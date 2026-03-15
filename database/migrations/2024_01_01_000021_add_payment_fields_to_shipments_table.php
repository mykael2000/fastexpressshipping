<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->string('payment_mode')->nullable()->after('service_level');
            $table->decimal('weight_kg', 8, 2)->nullable()->after('payment_mode');
            $table->text('remark')->nullable()->after('weight_kg');
        });
    }

    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn(['payment_mode', 'weight_kg', 'remark']);
        });
    }
};
