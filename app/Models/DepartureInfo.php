<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DepartureInfo extends Model
{
    protected $table = 'departure_info';
    protected $fillable = ['departure_id','date_from','date_to','type','text','status'];
}
