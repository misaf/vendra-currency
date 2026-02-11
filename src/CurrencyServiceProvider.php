<?php

declare(strict_types=1);

namespace Misaf\VendraCurrency;

use Filament\Panel;
use Illuminate\Foundation\Console\AboutCommand;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

final class CurrencyServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('vendra-currency')
            ->hasTranslations()
            ->hasMigrations([
                'create_currencies_table'
            ])
            ->hasInstallCommand(function (InstallCommand $command): void {
                $command->askToStarRepoOnGitHub('misaf/vendra-currency');
            });
    }

    public function packageRegistered(): void
    {
        Panel::configureUsing(function (Panel $panel): void {
            if ('admin' !== $panel->getId()) {
                return;
            }

            $panel->plugin(CurrencyPlugin::make());
        });
    }

    public function packageBooted(): void
    {
        AboutCommand::add('Vendra Currency', fn() => ['Version' => 'dev-master']);
    }
}
