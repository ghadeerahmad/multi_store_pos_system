<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function scopeStoreAdmin($query)
    {
        return $query->where('guard_name', 'store_admin');
    }
}