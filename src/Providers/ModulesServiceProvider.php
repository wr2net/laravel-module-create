<?php

namespace Src\LaravelModuleCreate\Providers;

use LMC\LaravelModuleCreate\Commands\StartCreateCommand;
use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands(StartCreateCommand::class);
        }
    }

    public function register(): void
    {
        $this->commands([
            StartCreateCommand::class,
        ]);
    }
}