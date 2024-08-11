<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductIn extends Model
{
    use HasFactory;
    protected $table = 'product_in';
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeGetByUser($val)
    {
        return $val;

        // if (auth()->user()->role_id == 1) {
        //     // admin
        //     return $val;
        // } else {
        //     return $val->where('user_id', auth()->id());
        // }
    }
}
