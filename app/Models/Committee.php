<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'position',
        'organization',
        'period',
        'type',
        'image',
    ];

    /**
     * Kunci organisasi selalu lowercase agar cocok dengan slug halaman
     * banom (ipnu, ippnu, fatayat, muslimat, banser, nu).
     */
    protected function organization(): Attribute
    {
        return Attribute::make(
            get: static fn (?string $value): string => strtolower((string) $value),
            set: static fn (?string $value): string => strtolower((string) $value),
        );
    }
}
