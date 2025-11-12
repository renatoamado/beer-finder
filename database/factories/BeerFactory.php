<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Beer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Beer>
 */
final class BeerFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     */
    protected $model = Beer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $beerStyles = [
            'IPA', 'Pale Ale', 'Lager', 'Stout', 'Porter', 'Wheat Beer',
            'Pilsner', 'Amber Ale', 'Brown Ale', 'Saison', 'Belgian Ale',
        ];

        $adjectives = [
            'Golden', 'Dark', 'Hoppy', 'Smooth', 'Crisp', 'Bold', 'Light',
            'Imperial', 'Double', 'Triple', 'Wild', 'Barrel-Aged', 'Session',
        ];

        $style = fake()->randomElement($beerStyles);
        $adjective = fake()->randomElement($adjectives);
        $name = fake()->boolean(70)
            ? sprintf('%s %s', $adjective, $style)
            : fake()->words(2, true) . ' ' . $style;

        return [
            'name' => ucwords($name),
            'tagline' => fake()->text(),
            'description' => fake()->paragraph(3),
            'first_brewed_at' => fake()->dateTimeBetween('-10 years'),
            'abv' => fake()->randomFloat(1, 3.5, 12.0), // Alcohol by volume
            'ibu' => fake()->numberBetween(10, 120), // International Bitterness Units
            'ebc' => fake()->numberBetween(4, 80), // European Brewery Convention (color)
            'ph' => fake()->randomFloat(1, 4.0, 5.5), // pH level
            'volume' => fake()->randomElement([330, 355, 473, 500, 568]), // ml
            'ingredients' => $this->generateIngredients(),
            'brewer_tips' => fake()->sentence(15),
        ];
    }

    /**
     * Indicate that the beer is a high alcohol content beer.
     */
    public function strongBeer(): self
    {
        return $this->state(fn (array $attributes): array => [
            'abv' => fake()->randomFloat(1, 8.0, 15.0),
            'ibu' => fake()->numberBetween(40, 120),
        ]);
    }

    /**
     * Indicate that the beer is a light session beer.
     */
    public function sessionBeer(): self
    {
        return $this->state(fn (array $attributes): array => [
            'abv' => fake()->randomFloat(1, 3.0, 5.0),
            'ibu' => fake()->numberBetween(10, 40),
            'name' => 'Session ' . fake()->randomElement(['IPA', 'Ale', 'Lager']),
        ]);
    }

    /**
     * Indicate that the beer is a dark beer.
     */
    public function darkBeer(): self
    {
        return $this->state(fn (array $attributes): array => [
            'ebc' => fake()->numberBetween(40, 80),
            'name' => fake()->randomElement(['Dark', 'Black', 'Imperial']) . ' ' .
                      fake()->randomElement(['Stout', 'Porter', 'Ale']),
        ]);
    }

    /**
     * Indicate that the beer is an IPA.
     */
    public function ipa(): self
    {
        return $this->state(fn (array $attributes): array => [
            'name' => fake()->randomElement(['American', 'West Coast', 'New England', 'Imperial']) . ' IPA',
            'abv' => fake()->randomFloat(1, 5.5, 8.5),
            'ibu' => fake()->numberBetween(50, 100),
            'tagline' => 'A hop-forward India Pale Ale',
        ]);
    }

    /**
     * Generate realistic beer ingredients.
     */
    private function generateIngredients(): string
    {
        $malts = [
            'Pale Malt', 'Munich Malt', 'Caramalt', 'Crystal Malt',
            'Chocolate Malt', 'Roasted Barley', 'Wheat Malt',
        ];

        $hops = [
            'Cascade', 'Centennial', 'Chinook', 'Citra', 'Mosaic',
            'Simcoe', 'Amarillo', 'Saaz', 'Hallertau', 'Fuggle',
        ];

        $yeasts = [
            'American Ale Yeast', 'English Ale Yeast', 'Belgian Ale Yeast',
            'Lager Yeast', 'Wheat Beer Yeast', 'Saison Yeast',
        ];

        $selectedMalts = fake()->randomElements($malts, fake()->numberBetween(2, 4));
        $selectedHops = fake()->randomElements($hops, fake()->numberBetween(1, 3));
        $selectedYeast = fake()->randomElement($yeasts);

        $ingredients = [
            'Malts: ' . implode(', ', $selectedMalts),
            'Hops: ' . implode(', ', $selectedHops),
            'Yeast: ' . $selectedYeast,
        ];

        return implode('; ', $ingredients);
    }
}
