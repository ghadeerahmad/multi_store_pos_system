<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory, SoftDeletes;

    protected $hidden = ['pivot'];

    public function store_roles()
    {
        return $this->hasMany(StoreRole::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_store_role');
    }
}
