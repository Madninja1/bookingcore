<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Guide extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'experience_years',
        'is_active',
    ];

    protected $casts = [
        'is_active'        => 'boolean',
        'experience_years' => 'integer',
    ];

    public function bookings(): HasMany
    {
        return $this->hasMany(HuntingBooking::class);
    }
}
