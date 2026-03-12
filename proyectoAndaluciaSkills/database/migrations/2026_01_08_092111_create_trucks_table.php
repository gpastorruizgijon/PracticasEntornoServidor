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
    Schema::create('trucks', function (Blueprint $table) {
    $table->id();
    $table->string('plate')->unique();
    $table->string('model');
    $table->float('max_load_kg'); // Carga máxima permitida
    // Relación con Conductor (User)
    $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
    $table->softDeletes();
    $table->timestamps();
});
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trucks');
    }
};
