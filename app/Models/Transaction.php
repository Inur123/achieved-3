<?php

// app/Models/Transaction.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product_id', 'name', 'email', 'phone_number', 'status','snap_token','order_id','price'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }




}
