<?php

namespace App\LaravelModuleCreate\Helpers;

class CreateService
{
    /**
     * @param string $projectName
     * @param string $moduleName
     * @param string $className
     * @return string
     */
    public function toService(string $projectName, string $moduleName, string $className): string
    {
        $resource = (new HandleHelpers)->handleS($className);
        $base = "App\\" . $projectName . "\\" . $moduleName . "\\";
        $namespace = $base . "Services";
        $model = "use " . $base . "Models\\" . $className . ";";
        $repository = "use " . $base . "Models\\Repositories\\" . $className . "RepositoryInterface as " . $resource . "Repository;";
        $repositoryProperty = '$' . strtolower($resource) .'Repository';
        $setProperty = '$this->' . strtolower($resource) .'Repository';

        return <<<PHP
            <?php
            
            namespace {$namespace};
            
            {$model}
            {$repository}
            
            class {$className}
            {
                private {$repositoryProperty};
            
                public function __construct({$resource}Repository {$repositoryProperty})
                {
                    {$setProperty} = {$repositoryProperty};
                }
            }
            
            PHP;
    }
}