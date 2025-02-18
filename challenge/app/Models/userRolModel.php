<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class userRolModel extends Model
{
    protected $table='tabla_user_rol';

    protected $fillable=[
        'user_id',
        'role_id'
    ];
}
