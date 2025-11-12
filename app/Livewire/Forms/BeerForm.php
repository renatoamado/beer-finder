<?php

declare(strict_types=1);

namespace App\Livewire\Forms;

use App\Models\Beer;
use Livewire\Form;

final class BeerForm extends Form
{
    public ?Beer $beer = null;

    public string $name = '';

    public ?string $tagline = null;

    public string $description = '';

    public string $first_brewed_at = '';

    public string $abv = '';

    public string $ibu = '';

    public string $ebc = '';

    public string $ph = '';

    public string $volume = '';

    public ?string $ingredients = null;

    public ?string $brewer_tips = null;

    public function setBeer(Beer $beer): void
    {
        $this->beer = $beer;
        $this->name = $beer->name;
        $this->tagline = $beer->tagline;
        $this->description = $beer->description;
        $this->first_brewed_at = $beer->first_brewed_at->format('Y-m-d');
        $this->abv = (string) $beer->abv;
        $this->ibu = (string) $beer->ibu;
        $this->ebc = (string) $beer->ebc;
        $this->ph = (string) $beer->ph;
        $this->volume = (string) $beer->volume;
        $this->ingredients = $beer->ingredients;
        $this->brewer_tips = $beer->brewer_tips;
    }

    /** @return array<string, mixed> */
    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'tagline' => 'required|string|min:3|max:255',
            'description' => 'required|string|min:3|max:1000',
            'first_brewed_at' => 'required|date',
            'abv' => 'required|numeric|min:0|max:100',
            'ibu' => 'required|numeric|min:0|max:200',
            'ebc' => 'required|numeric|min:0|max:100',
            'ph' => 'required|numeric|min:0|max:14',
            'volume' => 'required|numeric|min:0|max:1000',
            'ingredients' => 'required|string|min:3|max:1000',
            'brewer_tips' => 'required|string|min:3|max:1000',
        ];
    }

    public function store(): Beer
    {
        /** @var array<string, mixed> $validated */
        $validated = $this->validate();

        return Beer::query()->create($validated);
    }

    public function update(): ?Beer
    {
        /** @var array<string, mixed> $validated */
        $validated = $this->validate();

        $this->beer?->update($validated);

        return $this->beer?->fresh();
    }
}
