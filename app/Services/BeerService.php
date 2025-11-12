<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Beer;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

final class BeerService
{
    /**
     * @param  array<string>  $filters
     * @return LengthAwarePaginator<int, Beer>
     */
    public function getBeers(string $sortBy, string $sortDirection, array $filters): LengthAwarePaginator
    {
        $query = Beer::query();

        if (isset($filters['name'])) {
            $valorEmbrulhado = Str::of($filters['name'])->wrap('%');

            $query->where('name', 'ilike', $valorEmbrulhado);
        }

        if (! empty($filters['prop_filter'])
            && ! empty($filters['prop_filter_rule'])
            && ! empty($filters['prop_filter_value'])

        ) {
            $query->where($filters['prop_filter'], $filters['prop_filter_rule'], $filters['prop_filter_value']);
        }

        if ($sortBy && $sortDirection) {
            $query->orderBy($sortBy, $sortDirection);
        }

        return $query->paginate(15);
    }
}
