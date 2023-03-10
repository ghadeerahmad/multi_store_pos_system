<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreRole extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function permissions()
    {
        return $this->belongsToMany(StorePermission::class, 'store_role_permissions');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
