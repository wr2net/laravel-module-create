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
            ->hasConfigFile()
            ->hasCommands([
                GenerateProjectCommand::class,
                GenerateModuleCommand::class,
                GenerateScaffoldCommand::class,
            ])
            ->hasInstallCommand(function (InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->askToRunMigrations()
                    ->copyAndRegisterServiceProviderInApp()
                    ->addCommands([
                        GenerateProjectCommand::class,
                        GenerateModuleCommand::class,
                        GenerateScaffoldCommand::class,
                    ]);
            });
    }
}