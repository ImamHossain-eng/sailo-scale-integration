<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_number',
        'default_driver_name',
        'default_driver_phone',
        'default_transport_name',
        'default_wheels_count',
    ];

    /**
     * Get the weighing transactions for the vehicle.
     */
    public function weighings(): HasMany
    {
        return $this->hasMany(Weighing::class);
    }
}
