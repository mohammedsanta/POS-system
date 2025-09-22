<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'item',
        'phone',
        'address',
        'deposit',
        'selling_price',
        'booking_date',
    ];
}
