<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class DriverVehicle extends Model
{
    use HasFactory, AsSource;

    protected $table = 'driver_vehicle';

    protected $fillable = [
        'driver_id',
        'vehicle_id',
    ];
}
