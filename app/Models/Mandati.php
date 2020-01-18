<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mandati extends Model
{
    protected $table = 'mandati';
    protected $fillable = ['company','supplier','anno','no'];
}
