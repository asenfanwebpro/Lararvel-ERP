<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProtocolData extends Model
{
    protected $table = 'protocol_data';
    protected $fillable = ['protocollid','note','filename'];
}
