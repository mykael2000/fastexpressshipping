<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained()->cascadeOnDelete();
            $table->string('channel'); // email, sms
            $table->string('recipient');
            $table->string('trigger'); // status_change, new_event
            $table->string('trigger_value')->nullable(); // e.g. the new status value, or event id
            $table->string('status'); // sent, failed, skipped
            $table->text('message')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('notification_logs'); }
};
