<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('shipment_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default('pending'); // pending, under_review, payment_required, approved, denied, cancelled
            // Sender
            $table->string('sender_name');
            $table->string('sender_email');
            $table->string('sender_phone');
            $table->string('sender_address1');
            $table->string('sender_address2')->nullable();
            $table->string('sender_city');
            $table->string('sender_state')->nullable();
            $table->string('sender_postal');
            $table->string('sender_country');
            // Recipient
            $table->string('recipient_name');
            $table->string('recipient_email');
            $table->string('recipient_phone');
            $table->string('recipient_address1');
            $table->string('recipient_address2')->nullable();
            $table->string('recipient_city');
            $table->string('recipient_state')->nullable();
            $table->string('recipient_postal');
            $table->string('recipient_country');
            // Pickup
            $table->string('pickup_type')->default('dropoff'); // dropoff, scheduled
            $table->date('pickup_date')->nullable();
            $table->string('pickup_time_window')->nullable();
            $table->text('pickup_instructions')->nullable();
            // Delivery
            $table->string('service_level')->default('standard');
            $table->boolean('signature_required')->default(false);
            $table->boolean('insurance_required')->default(false);
            $table->text('delivery_instructions')->nullable();
            // Compliance
            $table->boolean('prohibited_items_acknowledged')->default(false);
            $table->boolean('terms_accepted')->default(false);
            $table->text('notes')->nullable();
            // Admin
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->text('admin_notes')->nullable();
            $table->foreignId('shipment_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('shipment_requests');
    }
};
