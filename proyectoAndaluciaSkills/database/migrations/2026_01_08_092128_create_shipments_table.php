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
    $table->foreignId('waste_id')->constrained();
    $table->foreignId('truck_id')->constrained();
    $table->foreignId('recycling_plant_id')->constrained();
    
    $table->float('kilos_transported');
    $table->dateTime('pickup_date');   // Fecha de recogida
    $table->dateTime('delivery_date'); // Fecha de entrega
    
    // Estado del envío para el front
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
