<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Database\Eloquent\Model;

class Staff extends Authenticatable
{
    use HasFactory;
    protected $table = 'staffs';   // 👈 tell Eloquent which table to use

    // الأعمدة اللى مسموح بالتعبئة الجماعية لها
    protected $fillable = [
        'username',
        'password',
        // أضف أى أعمدة أخرى موجودة فى جدول staffs
    ];

    // لو عندك كلمة مرور لازم تتخزن مشفرة
    protected $hidden = [
        'password',
    ];

    // (اختياري) لتشفير كلمة المرور تلقائيًا
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = bcrypt($value);
        }
    }
    
}
