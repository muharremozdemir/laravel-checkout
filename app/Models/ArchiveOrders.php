<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArchiveOrders extends Model
{
    protected $table = "archive_orders";

    protected $fillable = [
        "order_id",
        "user_id",
        "total_amount",
        "status"
    ];

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProducts::class, 'order_id', 'order_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
