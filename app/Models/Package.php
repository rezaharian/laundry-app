<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    //
    protected $fillable = ['nama', 'deskripsi'];

    public function items()
    {
        return $this->hasMany(PackageItem::class);
    }
}