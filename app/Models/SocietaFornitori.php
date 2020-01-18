<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocietaFornitori extends Model
{
    protected $table = 'societa_fornitori';
    protected $fillable = ['ragione_sociale','citta','indirizzo','cap','iva','cf','sdi','mail','pec','tel','fax','logo','category'];
}
