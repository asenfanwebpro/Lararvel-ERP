<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcommerceOrderDetail extends Model
{
    protected $table = 'shopping_orderdetail';
    protected $fillable = ['orderid','productid','amount'];
}
