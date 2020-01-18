<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MandatiInvoice extends Model
{
    protected $table = 'mandati_invoice';
    protected $fillable = ['mandati_id','invoice_num','voicedate','voiceamount'];
}
