<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vessel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'party_id',
        'status',
        'arrival_date',
        'unload_start_datetime',
        'unload_end_datetime',
        'daily_rent_rate',
        'cargo_rate_per_ton',
    ];

    protected $casts = [
        'arrival_date' => 'date',
        'unload_start_datetime' => 'datetime',
        'unload_end_datetime' => 'datetime',
        'daily_rent_rate' => 'decimal:2',
        'cargo_rate_per_ton' => 'decimal:2',
    ];

    /**
     * Get the party/client that this vessel is unloading for.
     */
    public function party(): BelongsTo
    {
        return $this->belongsTo(Party::class);
    }

    /**
     * Get all weighing transactions under this vessel.
     */
    public function weighings(): HasMany
    {
        return $this->hasMany(Weighing::class);
    }

    /**
     * Accessor: Compute number of active stay days.
     * Portion of a day counts as a full day. Billed only during active unloading status.
     */
    public function getStayDaysAttribute(): int
    {
        if (!$this->unload_start_datetime) {
            return 0;
        }

        $start = Carbon::parse($this->unload_start_datetime);
        $end = $this->unload_end_datetime ? Carbon::parse($this->unload_end_datetime) : Carbon::now();

        // Calculate hours and ceil division by 24 (part of a day = full day)
        $hours = $start->diffInHours($end);
        
        // Return at least 1 day if unloading has commenced
        return (int) max(1, ceil($hours / 24));
    }

    /**
     * Accessor: Sum total completed cargo weight in Metric Tons.
     */
    public function getTotalTonnageAttribute(): float
    {
        return (float) ($this->weighings()->completed()->sum('net_weight') / 1000);
    }

    /**
     * Accessor: Calculate cargo fee (BDT 40/ton).
     */
    public function getCargoBillAttribute(): float
    {
        return $this->total_tonnage * floatval($this->cargo_rate_per_ton);
    }

    /**
     * Accessor: Calculate stay rent fee (BDT 1000/day).
     */
    public function getRentBillAttribute(): float
    {
        return $this->stay_days * floatval($this->daily_rent_rate);
    }

    /**
     * Accessor: Calculate total aggregated bill.
     */
    public function getTotalBillAttribute(): float
    {
        return $this->cargo_bill + $this->rent_bill;
    }
}
