<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

final class BeerStore extends Pivot
{
    protected $fillable = [
        'beer_id',
        'store_id',
        'price',
        'url',
        'promo_label',
    ];

    protected $casts = [
        'price' => 'integer',
        'beer_id' => 'integer',
        'store_id' => 'integer',
    ];
}
