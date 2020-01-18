<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcommerceOrder extends Model
{
    protected $table = 'shopping_order';
    protected $fillable = ['companyid','supplierid','anno','no','fname','mnumber','aptnumber','landmark','city','pincode','state','payment'];
}
