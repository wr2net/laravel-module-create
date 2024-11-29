<?php

namespace App\LaravelModuleCreate\Providers;

use App\LaravelModuleCreate\Console\Commands\GenerateProjectCommand;
use App\LaravelModuleCreate\Console\Commands\GenerateModuleCommand;
use App\LaravelModuleCreate\Console\Commands\GenerateScaffoldCommand;
use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands(GenerateProjectCommand::class);
            $this->commands(GenerateModuleCommand::class);
            $this->commands(GenerateScaffoldCommand::class);
        }
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