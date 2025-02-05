<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model {
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'image','status'];

    public function getFormattedPriceAttribute() {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function transactions()
{
    return $this->belongsToMany(Transaction::class);
}

 // Method to get the total quantity sold
 public function getTotalSoldAttribute()
 {
     return $this->productTransactions->sum('quantity'); // Summing up the quantity from the productTransactions table
 }
 public function productTransactions()
 {
     return $this->hasMany(ProductTransaction::class);
 }
}
