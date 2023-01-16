<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Driver extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $fillable = [
        'full_name',
        'birthdate',
        'photo',
        'license',
        'license_series',
        'license_id',
        'license_get_date'
    ];

    protected $casts = [
        'birthdate' => 'date',
        'license_get_date' => 'date'
    ];

    protected $allowedFilters = [
        'full_name',
        'birthdate',
        'license_series',
        'license_id',
        'license_get_date'
    ];

    protected $allowedSorts = [
        'full_name',
        'birthdate',
        'license_series',
        'license_id',
        'license_get_date'
    ];

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class);
    }
}
