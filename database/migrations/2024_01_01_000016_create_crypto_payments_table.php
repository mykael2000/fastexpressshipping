<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('crypto_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('coin'); // BTC, ETH, USDT_TRC20
            $table->string('network')->nullable();
            $table->string('wallet_address');
            $table->decimal('amount_usd', 12, 2);
            $table->decimal('amount_crypto', 20, 8)->nullable();
            $table->string('status')->default('pending'); // pending, submitted, paid, rejected, expired
            $table->string('tx_hash')->nullable();
            $table->string('proof_path')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('crypto_payments');
    }
};
