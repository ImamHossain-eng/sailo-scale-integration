<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Weighing extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'status',
        'party_id',
        'vehicle_id',
        'vessel_id',
        'driver_name',
        'driver_phone',
        'transport_name',
        'wheels_count',
        'product_name',
        'quantity',
        'challan_reference',
        'first_weight',
        'second_weight',
        'net_weight',
        'first_weight_datetime',
        'second_weight_datetime',
        'created_by',
        'completed_by',
    ];

    protected $casts = [
        'first_weight' => 'decimal:2',
        'second_weight' => 'decimal:2',
        'net_weight' => 'decimal:2',
        'quantity' => 'decimal:2',
        'first_weight_datetime' => 'datetime',
        'second_weight_datetime' => 'datetime',
        'wheels_count' => 'integer',
        'party_id' => 'integer',
        'vehicle_id' => 'integer',
        'vessel_id' => 'integer',
    ];

    /**
     * Get the party / customer.
     */
    public function party(): BelongsTo
    {
        return $this->belongsTo(Party::class);
    }

    /**
     * Get the vehicle.
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the vessel / ship.
     */
    public function vessel(): BelongsTo
    {
        return $this->belongsTo(Vessel::class);
    }

    /**
     * Get the user who registered the first weight.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who registered the second weight.
     */
    public function completer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

    /**
     * Scope a query to only include pending weighings.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include completed weighings.
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
