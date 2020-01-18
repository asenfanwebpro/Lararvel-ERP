<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcommerceBrand extends Model
{
    protected $table = 'shopping_brand';
    protected $fillable = ['brand','description'];
}
