<?php

namespace App\LaravelModuleCreate\Helpers;

class CreateProvider
{
    /**
     * @param string $projectName
     * @param string $moduleName
     * @return string
     */
    public function createAppServiceProvider(string $projectName, string $moduleName): string
    {
        $className = (new HandleHelpers)->handleS($moduleName);
        $namespace = "App\\" . $projectName . "\\" . $moduleName . "\\Providers";
        $setRepositoryInterface = "App\\" . $projectName . "\\" . $moduleName . "\\Models\\Repositories\\" . $className . "RepositoryInterface";
        $setRepository = "App\\" . $projectName . "\\" . $moduleName . "\\Models\\Repositories\\" . $className . "Repository";
        $app = '$this->app';

        return <<<PHP
        <?php
            
        namespace {$namespace};
            
        use Illuminate\Support\ServiceProvider;
            
        class AppServiceProvider extends ServiceProvider
        {
            /**
             * Bootstrap any application services.
             *
             * @return void
             */
            public function boot()
            {
                //
            }
            
            /**
             * Register any application services.
             *
             * @return void
             */
            public function register()
            {
                {$app}->bind(
                    '{$setRepositoryInterface}',
                    '{$setRepository}'
                );
            }
        }
        PHP;
    }

    /**
     * @param string $projectName
     * @param string $moduleName
     * @return string
     */
    public function createRouteServiceProvider(string $projectName, string $moduleName): string
    {
        $className = (new HandleHelpers)->handleS($moduleName);
        $modelName = strtolower($className);
        $namespace = "App\\" . $projectName . "\\" . $moduleName . "\\Providers";
        $routeTrait = "App\\{$projectName}\\Common\\Traits\\RouteServiceProviderTrait";
        $model = "App\\{$projectName}\\{$moduleName}\\Models\\{$className}";

        $toNamespace = '$namespace';
        $routePath = '$routePath';
        $toRoutePath = "{$projectName}\\{$moduleName}\\Routes";
        $value = '$value';

        return <<<PHP
            <?php
            
            use {$routeTrait};
            use {$model};
            use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
            use Illuminate\Support\Facades\Route;
            
            class RouteServiceProvider extends ServiceProvider
            {
                use RouteServiceProviderTrait;
            
                /**
                 * This namespace is applied to your controller routes.
                 *
                 * In addition, it is set as the URL generator's root namespace.
                 *
                 * @var string
                 */
                protected {$toNamespace} = '{$namespace}';
            
                /**
                 * @var string
                 */
                protected {$routePath} = '{$toRoutePath}';
            
                /**
                 * Define your route model bindings, pattern filters, etc.
                 *
                 * @return void
                 */
                public function boot()
                {
                    Route::bind('{$modelName}', function ({$value}) {
                        return {$className}::withTrashed()->find({$value});
                    });
            
                    parent::boot();
                }
            }
        PHP;
    }
}