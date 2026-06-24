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
        Schema::create('weighings', function (Blueprint $table) {
            $table->id();
            
            // Ticket ID (Sequential ticket number matching legacy 'TID')
            $table->string('ticket_number')->unique()->index();
            
            // Lifecycle Status
            $table->enum('status', ['pending', 'completed'])->default('pending')->index();
            
            // Normalized Entity References
            $table->foreignId('party_id')->constrained('parties')->onDelete('restrict');
            $table->foreignId('vehicle_id')->constrained('vehicles')->onDelete('restrict');
            $table->foreignId('vessel_id')->constrained('vessels')->onDelete('restrict');
            
            // Transaction-specific Details (Snapshot fields in case master records are updated later)
            $table->string('driver_name')->nullable();
            $table->string('driver_phone')->nullable();
            $table->string('transport_name')->nullable();
            $table->integer('wheels_count')->nullable();
            
            // Product & Cargo Details
            $table->string('product_name')->nullable();
            $table->decimal('quantity', 12, 2)->nullable();
            $table->string('challan_reference')->nullable();
            
            // Weighing Information
            $table->decimal('first_weight', 10, 2);
            $table->decimal('second_weight', 10, 2)->nullable();
            $table->decimal('net_weight', 10, 2)->nullable();
            
            // Timestamps
            $table->dateTime('first_weight_datetime')->useCurrent();
            $table->dateTime('second_weight_datetime')->nullable();
            
            // Audit Trails (Foreign keys referencing users table)
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('completed_by')->nullable()->constrained('users')->onDelete('set null');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weighings');
    }
};
