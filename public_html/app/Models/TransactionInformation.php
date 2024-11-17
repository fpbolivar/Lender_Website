<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransactionInformation extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'customer_name',
        'take_money',
        'return_take_money',
        'give_money',
        'received_give_money',
        'phone_number',
        'note',
        'date',
        'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transaction_details(): HasMany
    {
        return $this->hasMany(TransactionDetail::class);
    }

}
