<?php

// app/Models/ApprovedTransaction.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovedTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'approval_notes',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
