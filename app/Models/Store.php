<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\StoreFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

final class Store extends Model
{
    /** @use HasFactory<StoreFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'website',
        'phone',
        'opening_hours',
    ];

    protected $casts = [
        'opening_hours' => 'array',
        'user_id' => 'integer',
    ];

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return HasOne<Address, $this>
     */
    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    /**
     * @return BelongsToMany<Beer, $this, BeerStore, 'pivot'>
     */
    public function beers(): BelongsToMany
    {
        return $this->belongsToMany(Beer::class)
            ->using(BeerStore::class)
            ->withPivot('price', 'promo_label', 'url')
            ->withTimestamps();
    }

    /**
     * @return HasMany<CatalogItem, $this>
     */
    public function catalogItems(): HasMany
    {
        return $this->hasMany(CatalogItem::class);
    }

    /**
     * @return MorphMany<Image, $this>
     */
    public function images(): MorphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * @return MorphOne<Image, $this>
     */
    public function cover(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable')
            ->where('is_cover', true);
    }
}
