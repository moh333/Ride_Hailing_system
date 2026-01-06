<?php

namespace App\Infrastructure\Persistence\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TripModel extends Model
{
    use HasFactory;

    protected $table = 'trips';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'passenger_id',
        'driver_id',
        'origin_lat',
        'origin_lng',
        'dest_lat',
        'dest_lng',
        'status',
        'price',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'origin_lat' => 'float',
        'origin_lng' => 'float',
        'dest_lat' => 'float',
        'dest_lng' => 'float',
        'price' => 'float',
    ];
}
