<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    //
    protected $fillable = ['nama', 'harga', 'deskripsi'];

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'transaction_services');
    }
}