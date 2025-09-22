<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'supplier_id',
        'name',
        'brand',
        'category',
        'model',
        'purchase_price',
        'sale_price',
        'stock',
        'supplier',
        'description',
    ];

        public function getByCategory($id)
    {
        return Product::where('category_id', $id)
            ->select('id', 'name', 'sale_price', 'stock')
            ->orderBy('name')
            ->get();
    }

    public function barcodes()
    {
        return $this->hasMany(ProductBarcode::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id'); 
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }


}
