<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Beer;
use Illuminate\Database\Seeder;

final class BeerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a diverse collection of beers

        // Regular beers (50)
        Beer::factory()
            ->count(50)
            ->create();

        // Strong beers (10)
        Beer::factory()
            ->strongBeer()
            ->count(10)
            ->create();

        // Session beers (15)
        Beer::factory()
            ->sessionBeer()
            ->count(15)
            ->create();

        // Dark beers (10)
        Beer::factory()
            ->darkBeer()
            ->count(10)
            ->create();

        // IPAs (15)
        Beer::factory()
            ->ipa()
            ->count(15)
            ->create();

        $this->command->info('Created 100 beers successfully!');
    }
}
