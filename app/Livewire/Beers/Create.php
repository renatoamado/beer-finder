<?php

declare(strict_types=1);

namespace App\Livewire\Beers;

use App\Livewire\Forms\BeerForm;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;

final class Create extends Component
{
    public BeerForm $form;

    public function save(): RedirectResponse
    {
        $this->form->store();

        return to_route('beers.index')
            ->with('success', sprintf('%s criada com sucesso!', $this->form->name));
    }

    public function render(): ViewContract|ViewFactory
    {
        return view('livewire.beers.create');
    }
}
