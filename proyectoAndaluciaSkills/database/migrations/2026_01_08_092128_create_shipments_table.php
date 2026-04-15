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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('waste_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('truck_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('recycling_plant_id')->nullable()->constrained()->nullOnDelete();

            $table->decimal('kilos_transported', 10, 2);
            $table->dateTime('pickup_date');
            $table->dateTime('delivery_date')->nullable(); // Puede no tener fecha de entrega al crearse

            $table->enum('status', ['pending', 'in_transit', 'delivered'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
