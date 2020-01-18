<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MandatiNota extends Model
{
    protected $table = 'mandati_nota';
    protected $fillable = ['mandati_id','notes','notedate'];
}
