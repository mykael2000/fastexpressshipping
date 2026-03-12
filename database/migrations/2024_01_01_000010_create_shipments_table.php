<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number')->unique();
            $table->string('status')->default('created'); // created, picked_up, in_transit, out_for_delivery, delivered, exception
            $table->string('origin');
            $table->string('destination');
            $table->string('recipient_name');
            $table->string('recipient_email')->nullable();
            $table->string('recipient_phone')->nullable();
            $table->dateTime('eta')->nullable();
            $table->dateTime('shipped_date')->nullable();
            $table->string('service_level')->default('standard'); // standard, express, overnight
            $table->text('notes')->nullable();
            $table->boolean('notify_email')->default(true);
            $table->boolean('notify_sms')->default(false);
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('shipments'); }
};
