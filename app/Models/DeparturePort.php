<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeparturePort extends Model
{
    protected $table = 'departure_port';
    protected $fillable = ['port'];
}
