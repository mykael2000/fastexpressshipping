<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->string('sender_name')->nullable()->after('destination');
            $table->string('sender_email')->nullable()->after('sender_name');
            $table->string('sender_address')->nullable()->after('sender_email');
            $table->string('sender_phone')->nullable()->after('sender_address');
            $table->decimal('amount', 10, 2)->nullable()->after('weight_kg');
        });
    }

    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn(['sender_name', 'sender_email', 'sender_address', 'sender_phone', 'amount']);
        });
    }
};
