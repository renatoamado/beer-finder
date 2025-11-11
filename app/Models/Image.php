<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

final class Image extends Model
{
    protected $fillable = [
        'imageable_type',
        'imageable_id',
        'path',
        'is_cover',
    ];

    protected $casts = [
        'is_cover' => 'boolean',
    ];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }
}
