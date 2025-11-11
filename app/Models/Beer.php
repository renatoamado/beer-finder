<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

final class Beer extends Model
{
    protected $fillable = [
        'name',
        'tagline',
        'description',
        'first_brewed_at',
        'abv',
        'ibu',
        'ebc',
        'ph',
        'volume',
        'ingredients',
        'brewer_tips',
    ];

    protected $casts = [
        'first_brewed_at' => 'date',
        'abv' => 'decimal:2',
        'ibu' => 'integer',
        'ebc' => 'integer',
        'ph' => 'decimal:2',
        'volume' => 'integer',
    ];

    public function stores(): BelongsToMany
    {
        return $this->belongsToMany(Store::class)
            ->using(BeerStore::class)
            ->withPivot('price', 'promo_label', 'url')
            ->withTimestamps();
    }

    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function cover(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')
            ->where('is_cover', true);
    }
}
