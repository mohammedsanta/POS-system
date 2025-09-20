<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'supplier_name',
        'total',
        'notes',
        'purchased_at',
    ];

    /**
     * علاقة المشتريات مع الأصناف
     */
    public function items()
    {
        return $this->hasMany(PurchaseItem::class, 'purchase_id');
    }
}
