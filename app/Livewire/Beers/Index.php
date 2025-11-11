<?php

declare(strict_types=1);

namespace App\Livewire\Beers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

final class Index extends Component
{
    public function render(): View|Factory
    {
        return view('livewire.beers.index');
    }
}
