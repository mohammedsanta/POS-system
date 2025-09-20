<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

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
