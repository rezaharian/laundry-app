<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = [
        'user_id',
        'pelanggan_nama',
        'tanggal_masuk',
        'tanggal_keluar',
        'total_biaya',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(TransactionItem::class);
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, 'transaction_services');
    }
}