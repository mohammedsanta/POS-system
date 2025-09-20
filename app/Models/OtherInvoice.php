<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number', 'customer_name', 'product_id', 'price', 'quantity', 'total', 'notes'
    ];

}
