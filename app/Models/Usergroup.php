<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usergroup extends Model
{
    protected $table = 'usergroup';
    protected $fillable = ['group','permission'];
}
