<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcommerceProduct extends Model
{
    protected $table = 'shopping_product';
    protected $fillable = ['product','categoryid','productdescription','cost','brandid','image'];
}
