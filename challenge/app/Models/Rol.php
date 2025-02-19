<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    protected $table='rol';

    protected $fillable=[
        'name',
        'description'
    ];
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_rol', 'role_id', 'user_id');
    }
}
