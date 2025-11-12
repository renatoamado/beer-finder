<?php

declare(strict_types=1);

namespace App\Livewire\Beers;

use App\Livewire\Forms\BeerForm;
use App\Models\Beer;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;

final class Update extends Component
{
    public BeerForm $form;

    public Beer $beer;

    public function mount(Beer $beer): void
    {
        $this->beer = $beer;
        $this->form->setBeer($beer);
    }

    public function save(): RedirectResponse|Redirector
    {
        $this->form->update();

        /** @var RedirectResponse|Redirector $res */
        $res = to_route('beers.index')
            ->success(sprintf('%s atualizada com sucesso!', $this->form->name));

        return $res;
    }

    public function render(): ViewFactory|ViewContract
    {
        return view('livewire.beers.update');
    }
}
