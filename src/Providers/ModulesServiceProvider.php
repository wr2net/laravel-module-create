<?php

namespace Src\LaravelModuleCreate\Providers;

use Illuminate\Support\ServiceProvider;
use Src\LaravelModuleCreate\Console\Commands\GenerateModuleCommand;
use Src\LaravelModuleCreate\Console\Commands\GenerateProjectCommand;
use Src\LaravelModuleCreate\Console\Commands\GenerateScaffoldCommand;

class ModulesServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateProjectCommand::class,
                GenerateModuleCommand::class,
                GenerateScaffoldCommand::class,
            ]);
        }
    }

    public function register(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateProjectCommand::class,
                GenerateModuleCommand::class,
                GenerateScaffoldCommand::class,
            ]);
        }
    }
}