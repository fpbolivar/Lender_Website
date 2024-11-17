<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $table = 'transaction_details';

    protected $fillable = [
        'take_money',
        'return_take_money',
        'give_money',
        'received_give_money',
        'date',
        'transaction_id'
    ];

    public function transaction_information(): BelongsTo
    {
        return $this->belongsTo(TransactionInformation::class);
    }
}
