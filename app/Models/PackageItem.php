<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PackageItem extends Model
{
    //
    protected $fillable = ['package_id', 'nama_item', 'satuan', 'tipe', 'harga'];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}