<?php

namespace Src\LaravelModuleCreate\Helpers;

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
        $resource = $className;
        $base = "App\\" . $projectName . "\\" . $moduleName . "\\";
        $namespace = $base . "Services";
        $model = "use " . $base . "Models\\" . $className . ";";
        $repository = "use " . $base . "Models\\Repositories\\" . $className . "RepositoryInterface as " . $resource . "Repository;";
        $repositoryProperty = '$' . lcfirst($resource) .'Repository';
        $setProperty = '$this->' . lcfirst($resource) .'Repository';

        return <<<PHP
            <?php
            
            namespace {$namespace};
            
            {$model}
            {$repository}
            
            class {$className}Service
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