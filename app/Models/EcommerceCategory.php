<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcommerceCategory extends Model
{
    protected $table = 'shopping_category';
    protected $fillable = ['category','description'];
}
