<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Waybill extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $fillable = [
        'registration_number',
        'issued_at',
        'valid_for_days',
        'driver_id',
        'vehicle_id',
        'route_from',
        'route_to',
        'responsible_id',
        'status',
        'classifications'
    ];

    protected $casts = [
        'issued_at' => 'date',
        'classifications' => 'array'
    ];

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function responsible()
    {
        return $this->belongsTo(User::class);
    }
}
