<?php

namespace Wagner\LaravelModuleCreate\Helpers;

class CreateTraits
{
    /**
     * @var string
     */
    private string $trashed = '$this->trashed()';

    /**
     * @param string $projectName
     * @return string
     */
    public function toTraitSoftDelete(string $projectName): string
    {
        $namespace = "App\\" . $projectName . "\\Common\Traits";
        return <<<PHP
            <?php
            
            namespace {$namespace};
            
            use Illuminate\Database\Eloquent\SoftDeletes as EloquentSoftDeletes;
            
            trait SoftDeletes
            {
                use EloquentSoftDeletes;

                /**
                 * @return bool
                 */
                public function isEnabled()
                {
                    return {$this->trashed};
                }                
            }
            PHP;
    }

    /**
     * @param string $projectName
     * @return string
     */
    public function toTraitRouteServiceProvider(string $projectName): string
    {
        $mapApiRoutes = '$this->mapApiRoutes()';
        $mapWebRoutes = '$this->mapWebRoutes()';
        $routePath = '$this->routePath';
        $path = '$path';
        $toNamespace = '$this->namespace';
        $namespace = "App\\" . $projectName . "\\Common\Traits";
        return <<<PHP
            <?php
            
            namespace {$namespace};
            
            use Illuminate\Support\Facades\Route;
            
            trait RouteServiceProviderTrait
            {
                /**
                 * Define the routes for the application.
                 *
                 * @return void
                 */
                public function map()
                {
                    {$mapApiRoutes};
            
                    {$mapWebRoutes};
                }
            
                /**
                 * Define the "api" routes for the application.
                 *
                 * These routes are typically stateless.
                 *
                 * @return void
                 */
                protected function mapApiRoutes()
                {
                    {$path} = str_replace('\\\', DIRECTORY_SEPARATOR, app_path({$routePath}.'\api.php'));
                    Route::prefix('api')
                        ->as('api.')
                        ->middleware(['api', 'auth:api'])
                        ->namespace({$toNamespace}.'\Api')
                        ->group($path);
                }
            
                /**
                 * Define the "web" routes for the application.
                 *
                 * These routes all receive session state, CSRF protection, etc.
                 *
                 * @return void
                 */
                protected function mapWebRoutes()
                {
                    {$path} = str_replace('\\\', DIRECTORY_SEPARATOR, app_path({$routePath}.'\web.php'));
                    Route::middleware(['web', 'auth'])
                        ->namespace({$toNamespace}.'\Web')
                        ->group({$path});
                }             
            }
            PHP;
    }
}