<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    //
    protected $fillable = ['transaction_id', 'package_item_id', 'jumlah', 'subtotal'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function packageItem()
    {
        return $this->belongsTo(PackageItem::class);
    }
}