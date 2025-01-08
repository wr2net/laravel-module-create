<?php

namespace App\LaravelModuleCreate\Helpers;

class CreateRoute
{
    /**
     * @param string $moduleName
     * @param string $className
     * @return string
     */
    public function toApi(string $moduleName, string $className): string
    {
        $routeName = strtolower($moduleName);
        $valueName = '{' . strtolower($className) . '}';
        $controller = "{$className}Controller";
        return <<<PHP
            <?php
            
            Route::get('{$routeName}', '{$controller}@index')
                ->name('{$routeName}.index');
            
            Route::post('{$routeName}', '{$controller}@store')
                ->name('{$routeName}.store');
            
            Route::get('{$routeName}/{$valueName}', '{$controller}@show')
                ->name('{$routeName}.show');
            
            Route::put('{$routeName}/{$valueName}', '{$controller}@update')
                ->name('{$routeName}.update');
            
            Route::patch('{$routeName}/{$valueName}/disable', '{$controller}@disable')
                ->name('{$routeName}.disable');
            
            Route::patch('{$routeName}/{$valueName}/enable', '{$controller}@enable')
                ->name('{$routeName}.enable');
            
            Route::delete('{$routeName}/{$valueName}', '{$controller}@destroy')
                ->name('{$routeName}.destroy');
            PHP;
    }

    /**
     * @param string $moduleName
     * @param string $className
     * @return string
     */
    public function toWeb(string $moduleName, string $className): string
    {
        return <<<PHP
            <?php
            
            /*
            |--------------------------------------------------------------------------
            | Web Routes
            |--------------------------------------------------------------------------
            |
            | Here is where you can register web routes for your application. These
            | routes are loaded by the RouteServiceProvider within a group which
            | contains the "web" middleware group. Now create something great!
            |
            */
            
            PHP;
    }
}