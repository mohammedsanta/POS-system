<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    protected $fillable = [
        'purchase_id',
        'item_name',
        'brand',
        'imei',
        'qty',
        'price',
    ];

    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
}
