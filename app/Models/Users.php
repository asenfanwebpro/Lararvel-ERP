<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table = 'users';
    protected $fillable = ['parent_id','name','lastname','email','email_verified_at','password','remember_token'];

}
