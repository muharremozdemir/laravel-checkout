<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CheckoutProducts extends Model
{
    protected $table = "checkout_products";

    protected $fillable = [
        "user_id",
        "name",
        "email",
        "product_id",
        "title", //Tüm ürün sütunları, ürünlerin sepete atıldıktan sonraki admin tarafından yapılan değişikliklerden etkilenmemesi için açılmıştır.
        "image",
        "description",
        "price",
        "piece", // Adet
        "total_price" // Toplam tutar
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }
}
