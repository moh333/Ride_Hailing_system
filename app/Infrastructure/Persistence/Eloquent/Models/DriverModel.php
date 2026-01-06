<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DriverModel extends Model
{
    use HasFactory;

    protected $table = 'drivers';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'license_plate',
        'status',
        'latitude',
        'longitude',
        'current_trip_id',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];
}
