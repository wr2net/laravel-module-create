<?php

namespace App\LaravelModuleCreate\Providers;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use App\LaravelModuleCreate\Console\Commands\GenerateProjectCommand;
use App\LaravelModuleCreate\Console\Commands\GenerateModuleCommand;
use App\LaravelModuleCreate\Console\Commands\GenerateScaffoldCommand;

class ModulesServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('lm-create')
            ->hasCommands([
                GenerateProjectCommand::class,
                GenerateModuleCommand::class,
                GenerateScaffoldCommand::class,
            ]);
    }

    public function register(): void
    {
        $this->commands([
            GenerateProjectCommand::class,
            GenerateModuleCommand::class,
            GenerateScaffoldCommand::class,
        ]);
    }
}