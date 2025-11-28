<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    
// App\Models\Payment.php
protected $fillable = [
    'user_id',
    'amount',
    'status',
    'channel',
    'reference',
    'notes',
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
