<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTransaction extends Model
{
    use HasFactory;
    protected $table = 'product_transaction';

    protected $fillable = ['product_id', 'transaction_id', 'quantity'];

    // Relasi dengan model Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi dengan model Transaction
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
