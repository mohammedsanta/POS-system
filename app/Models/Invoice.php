<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'product_id',
        'is_returned',
        'category_id',
        'barcode_id',
        'invoice_number',
        'product_name',
        'customer_name',
        'qty',
        'price',
        'total',
        'sold_at',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    protected $casts = [
        'sold_at' => 'datetime', // <-- ensures sold_at is Carbon instance
    ];

    public function barcode()
    {
        return $this->belongsTo(ProductBarcode::class, 'barcode_id');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

}
