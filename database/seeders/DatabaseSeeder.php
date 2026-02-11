<?php

declare(strict_types=1);

namespace Misaf\VendraCurrency\Database\Seeders;

use Illuminate\Database\Seeder;
use Misaf\VendraCurrency\Models\Currency;
use Misaf\VendraCurrency\Models\CurrencyCategory;
use Misaf\VendraTenant\Models\Tenant;

final class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $tenant = Tenant::query()->first();

        if ( ! $tenant) {
            $this->command?->error('Tenants not found. Please run TenantSeeder first.');
            return;
        }

        $tenant->makeCurrent();

        $this->seedCurrencies($tenant);
    }

    private function seedCurrencies(Tenant $tenant): void
    {
        $categories = [
            [
                'name'        => 'Fiat Currencies',
                'description' => 'Traditional government-issued currencies',
                'slug'        => 'fiat-currencies',
                'status'      => true,
                'currencies'  => [
                    [
                        'name'            => 'US Dollar',
                        'description'     => 'United States Dollar',
                        'slug'            => 'us-dollar',
                        'iso_code'        => 'USD',
                        'conversion_rate' => 1.0,
                        'decimal_place'   => 2,
                        'buy_price'       => 100000,
                        'sell_price'      => 100000,
                        'is_default'      => true,
                        'position'        => 1,
                        'status'          => true,
                    ],
                    [
                        'name'            => 'Euro',
                        'description'     => 'European Union Euro',
                        'slug'            => 'euro',
                        'iso_code'        => 'EUR',
                        'conversion_rate' => 0.85,
                        'decimal_place'   => 2,
                        'buy_price'       => 85000,
                        'sell_price'      => 85000,
                        'is_default'      => false,
                        'position'        => 2,
                        'status'          => true,
                    ],
                ],
            ],
            [
                'name'        => 'Cryptocurrencies',
                'description' => 'Digital or virtual currencies',
                'slug'        => 'cryptocurrencies',
                'status'      => true,
                'currencies'  => [
                    [
                        'name'            => 'Bitcoin',
                        'description'     => 'Bitcoin cryptocurrency',
                        'slug'            => 'bitcoin',
                        'iso_code'        => 'BTC',
                        'conversion_rate' => 0.000025,
                        'decimal_place'   => 8,
                        'buy_price'       => 40000000,
                        'sell_price'      => 40000000,
                        'is_default'      => false,
                        'position'        => 3,
                        'status'          => true,
                    ],
                    [
                        'name'            => 'Ethereum',
                        'description'     => 'Ethereum cryptocurrency',
                        'slug'            => 'ethereum',
                        'iso_code'        => 'ETH',
                        'conversion_rate' => 0.0004,
                        'decimal_place'   => 8,
                        'buy_price'       => 2500000,
                        'sell_price'      => 2500000,
                        'is_default'      => false,
                        'position'        => 4,
                        'status'          => true,
                    ],
                ],
            ],
        ];

        foreach ($categories as $categoryData) {
            $category = CurrencyCategory::query()->updateOrCreate(
                [
                    'tenant_id' => $tenant->id,
                    'slug'      => $categoryData['slug'],
                ],
                [
                    'name'        => $categoryData['name'],
                    'description' => $categoryData['description'],
                    'status'      => $categoryData['status'],
                ],
            );

            foreach ($categoryData['currencies'] as $currencyData) {
                Currency::query()->updateOrCreate(
                    [
                        'tenant_id' => $tenant->id,
                        'slug'      => $currencyData['slug'],
                    ],
                    [
                        'currency_category_id' => $category->id,
                        'name'                 => $currencyData['name'],
                        'description'          => $currencyData['description'],
                        'iso_code'             => $currencyData['iso_code'],
                        'conversion_rate'      => $currencyData['conversion_rate'],
                        'decimal_place'        => $currencyData['decimal_place'],
                        'buy_price'            => $currencyData['buy_price'],
                        'sell_price'           => $currencyData['sell_price'],
                        'is_default'           => $currencyData['is_default'],
                        'position'             => $currencyData['position'],
                        'status'               => $currencyData['status'],
                    ],
                );
            }
        }

        $this->command?->info("Currencies seeded successfully for {$tenant->slug} tenant.");
        $this->command?->info('- 2 currency categories (Fiat, Crypto)');
        $this->command?->info('- 4 currencies (USD, EUR, BTC, ETH)');
    }
}
