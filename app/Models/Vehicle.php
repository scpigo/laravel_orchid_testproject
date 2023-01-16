<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Vehicle extends Model
{
    use HasFactory, AsSource, Filterable;

    protected $fillable = [
        'brand',
        'color',
        'photo',
        'government_number'
    ];

    public function drivers()
    {
        return $this->belongsToMany(Driver::class);
    }
}
