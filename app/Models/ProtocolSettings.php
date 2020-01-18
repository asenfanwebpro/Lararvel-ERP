<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProtocolSettings extends Model
{
    protected $table = 'protocol_settings';
    protected $fillable = ['company','section','progress'];
}
