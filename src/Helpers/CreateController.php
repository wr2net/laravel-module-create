<?php

namespace Wagner\LaravelModuleCreate\Helpers;

class CreateController
{
    /**
     * @param string $projectName
     * @param string $moduleName
     * @param string $className
     * @return string
     */
    public function toController(string $projectName, string $moduleName, string $className): string
    {
        $namespace = "App\\" . $projectName . "\\" . $moduleName;
        return <<<PHP
            <?php
            
            namespace {$namespace};
            
            use App\Http\Controllers\Controller;
            
            class {$className}Controller extends Controller
            {
                public function __construct()
                {
            
                }
            }
            PHP;
    }
}