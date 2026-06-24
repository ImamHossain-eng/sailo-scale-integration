<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Party extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'contact_person',
        'contact_number',
    ];

    /**
     * Get the weighing transactions for the party.
     */
    public function weighings(): HasMany
    {
        return $this->hasMany(Weighing::class);
    }
}
