<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Protocol extends Model
{
    protected $table = 'protocoll';
    protected $fillable = ['company','section','anno','no','extra'];
}
