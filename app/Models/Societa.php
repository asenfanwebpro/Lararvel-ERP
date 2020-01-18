<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Societa extends Model
{
    protected $table = 'societa';
    protected $fillable = ['ragione_sociale','citta','indirizzo','cap','iva','cf','sdi','mail','pec','tel','fax'];

}
