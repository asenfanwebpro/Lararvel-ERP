<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartureTime extends Model
{
    protected $table = 'departure_time';
    protected $fillable = ['route_id','ship_id','time','week','group','status'];
}
