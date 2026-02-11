<?php

declare(strict_types=1);

namespace Misaf\VendraCurrency\Tests;

use Illuminate\Support\Facades\Http;
use Misaf\VendraCurrency\CurrencyServiceProvider;
use Orchestra\Testbench\TestCase as TestbenchTestCase;
use Override;

abstract class TestCase extends TestbenchTestCase
{
    #[Override]
    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();
    }

    protected function getPackageProviders($app): array
    {
        return [
            CurrencyServiceProvider::class,
        ];
    }
}
