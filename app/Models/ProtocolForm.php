<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProtocolForm extends Model
{
    protected $table = 'protocol_form';
    protected $fillable = ['company','section','formhtml'];
}
