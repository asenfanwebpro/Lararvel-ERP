<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MandatiPayment extends Model
{
    protected $table = 'mandati_payment';
    protected $fillable = ['mandati_id','method','paydate','transaction','payamount'];
}
