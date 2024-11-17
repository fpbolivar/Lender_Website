<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusinessCard extends Model
{
    use HasFactory;

    protected $table = 'business_cards';

    protected $fillable = ['business_name', 
                            'phone_number',
                            'email',
                            'business_address',
                            'user_id'];

    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
