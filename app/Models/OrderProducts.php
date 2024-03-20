<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProducts extends Model
{
    protected $table = "order_products";

    //Fillable yerine $quarded = [] ile de yapılabiliyor ama ben dataların kontrolü ve olası hataları görebilmek için $fillable tercih ediyorum.
    protected $fillable = [
        "order_id",
        "product_id",
        "title",
        "image",
        "description",
        "price",
        "piece",
        "total_price"
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
