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
        Schema::create('vessels', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->foreignId('party_id')->constrained('parties')->onDelete('cascade');
            $table->enum('status', ['pending', 'active', 'inactive'])->default('pending')->index();
            $table->date('arrival_date')->nullable();
            $table->dateTime('unload_start_datetime')->nullable();
            $table->dateTime('unload_end_datetime')->nullable();
            $table->decimal('daily_rent_rate', 10, 2)->default(1000.00);
            $table->decimal('cargo_rate_per_ton', 10, 2)->default(40.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vessels');
    }
};
