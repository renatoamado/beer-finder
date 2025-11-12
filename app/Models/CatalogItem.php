<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class CatalogItem extends Model
{
    protected $fillable = [
        'store_id',
        'name',
        'url',
        'description',
        'ingredients',
        'price',
    ];

    protected $casts = [
        'price' => 'integer',
        'store_id' => 'integer',
    ];

    /**
     * @return BelongsTo<Store, $this>
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
