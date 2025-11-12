<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Store>
 */
final class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $storeTypes = [
            'Cervejaria', 'Bar', 'Pub', 'Brewpub', 'Distribuidora',
            'Empório', 'Adega', 'Casa de Cervejas', 'Taberna',
        ];

        $name = fake()->company() . ' ' . (fake()->boolean(70) ? fake()->randomElement($storeTypes) : '');

        return [
            'user_id' => User::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
            'website' => fake()->boolean(70) ? fake()->url() : null,
            'phone' => fake()->boolean(80) ? fake()->phoneNumber() : null,
            'opening_hours' => $this->generateOpeningHours(),
        ];
    }

    /**
     * Indicate that the store has a website.
     */
    public function withWebsite(): self
    {
        return $this->state(fn (array $attributes): array => [
            'website' => fake()->url(),
        ]);
    }

    /**
     * Indicate that the store is open 24/7.
     */
    public function alwaysOpen(): self
    {
        return $this->state(fn (array $attributes): array => [
            'opening_hours' => array_fill_keys(
                ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'],
                ['open' => '00:00', 'close' => '23:59']
            ),
        ]);
    }

    /**
     * Generate realistic opening hours.
     */
    private function generateOpeningHours(): array
    {
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $hours = [];

        foreach ($days as $day) {
            // Weekend might have different hours
            if (in_array($day, ['saturday', 'sunday'])) {
                $hours[$day] = fake()->boolean(80) ? [
                    'open' => fake()->randomElement(['10:00', '11:00', '12:00']),
                    'close' => fake()->randomElement(['22:00', '23:00', '00:00']),
                ] : null; // Some stores might be closed on Sunday
            } else {
                $hours[$day] = [
                    'open' => fake()->randomElement(['08:00', '09:00', '10:00']),
                    'close' => fake()->randomElement(['18:00', '19:00', '20:00', '21:00']),
                ];
            }
        }

        return $hours;
    }
}
