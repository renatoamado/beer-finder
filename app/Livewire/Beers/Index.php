<?php

declare(strict_types=1);

namespace App\Livewire\Beers;

use App\Models\Beer;
use App\Services\BeerService;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View as ViewContract;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

final class Index extends Component
{
    use WithPagination;

    public string $sortBy = '';

    public string $sortDirection = '';

    /** @var array<string> */
    public array $filters = [];

    private BeerService $beerService;

    public function boot(BeerService $beerService): void
    {
        $this->beerService = $beerService;
    }

    public function sort(string $sortBy): void
    {
        $this->sortBy = $sortBy;
        $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';

        $this->resetPage();
    }

    public function filter(): void
    {
        $this->validate([
            'filters.name' => 'nullable|string|min:3|max:255',
            'filters.prop_filter' => 'nullable',
            'filters.prop_filter_rule' => 'required_with:filters.prop_filter',
            'filters.prop_filter_value' => 'required_with:filters.prop_filter_rule',
        ]);

        $this->resetPage();
    }

    public function remove(Beer $beer): void
    {
        $beer->delete();
        Toaster::success(sprintf('%s foi removida com sucesso.', $beer->name));
    }

    public function render(): ViewContract|ViewFactory
    {
        return view('livewire.beers.index', [
            'beers' => $this->beerService->getBeers($this->sortBy, $this->sortDirection, $this->filters),
        ]);
    }
}
