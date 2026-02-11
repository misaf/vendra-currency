<?php

declare(strict_types=1);

namespace Misaf\VendraCurrency\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Misaf\VendraCurrency\Models\Currency;
use Misaf\VendraCurrency\Models\CurrencyCategory;
use Misaf\VendraTenant\Models\Tenant;

/**
 * @extends Factory<Currency>
 */
final class CurrencyFactory extends Factory
{
    protected $model = Currency::class;

    public function definition(): array
    {
        return [
            'tenant_id'            => Tenant::factory(),
            'currency_category_id' => fn(array $attributes) => CurrencyCategory::factory()->forTenant($attributes['tenant_id']),
            'name'                 => fake()->sentences(1, true),
            'description'          => fake()->realTextBetween(100, 200),
            'slug'                 => fn(array $attributes) => Str::slug($attributes['name']),
            'iso_code'             => fake()->languageCode(),
            'is_default'           => fake()->boolean(1),
            'buy_price'            => fake()->numberBetween(70000, 100000),
            'sell_price'           => fake()->numberBetween(70000, 100000),
            'status'               => fake()->boolean(80),
        ];
    }

    public function forTenant(Tenant $tenant): static
    {
        return $this->state(fn(): array => ['tenant_id' => $tenant->id]);
    }

    public function forCategory(CurrencyCategory $currencyCategory): static
    {
        return $this->state(fn(): array => [
            'tenant_id'            => $currencyCategory->tenant_id,
            'currency_category_id' => $currencyCategory->id,
        ]);
    }

    public function enabled(): static
    {
        return $this->state(fn(): array => ['status' => true]);
    }

    public function disabled(): static
    {
        return $this->state(fn(): array => ['status' => false]);
    }
}
