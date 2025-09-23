<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

protected $fillable = [
        'name',
        'category_id',
        'supplier_id',
        'barcode',
        'brand',
        'model',
        'purchase_price',
        'sale_price',
        'stock',
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
        return $this->hasMany(ProductBarcode::class, 'product_id');
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
