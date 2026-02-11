<?php

declare(strict_types=1);

namespace Misaf\VendraCurrency\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Misaf\VendraCurrency\Models\CurrencyCategory;
use Misaf\VendraTenant\Models\Tenant;

/**
 * @extends Factory<CurrencyCategory>
 */
final class CurrencyCategoryFactory extends Factory
{
    protected $model = CurrencyCategory::class;

    public function definition(): array
    {
        return [
            'tenant_id'   => Tenant::factory(),
            'name'        => fake()->sentences(1, true),
            'description' => fake()->realTextBetween(100, 200),
            'slug'        => fn(array $attributes) => Str::slug($attributes['name']),
            'status'      => fake()->boolean(80),
        ];
    }

    public function forTenant(Tenant|int $tenant): static
    {
        $tenantId = $tenant instanceof Tenant ? $tenant->id : $tenant;

        return $this->state(fn(): array => ['tenant_id' => $tenantId]);
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
