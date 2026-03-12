<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('package_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_request_id')->constrained()->cascadeOnDelete();
            $table->string('package_type')->default('box');
            $table->integer('quantity')->default(1);
            $table->decimal('weight', 10, 3);
            $table->string('weight_unit')->default('kg');
            $table->decimal('length', 10, 2)->nullable();
            $table->decimal('width', 10, 2)->nullable();
            $table->decimal('height', 10, 2)->nullable();
            $table->string('dimension_unit')->default('cm');
            $table->decimal('declared_value', 12, 2)->nullable();
            $table->string('currency')->default('USD');
            $table->text('contents_description');
            $table->string('hs_code')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('package_items');
    }
};
