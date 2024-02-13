<?php

namespace Wagner\LaravelModuleCreate\Helpers;

class CreateModel
{
    public function toModel(string $projectName, string $moduleName, string $className): string
    {
        $namespace = "App\\" . $projectName . "\\" . $moduleName;
        return <<<PHP
            <?php
            
            namespace {$namespace};
            
            use Illuminate\Database\Eloquent\Model;
            
            class {$className} extends Model
            {
                use SoftDeletes;
            }
            PHP;
    }

    /**
     * @param string $projectName
     * @param string $moduleName
     * @param string $className
     * @return string
     */
    public function toModelRepository(string $projectName, string $moduleName, string $className): string
    {
        $namespace = "App\\" . $projectName . "\\" . $moduleName . "\\Models\\Repositories";
        $model = "use App\\" . $projectName . "\\" . $moduleName . "\\Models\\Repositories";
        return <<<PHP
            <?php
            
            namespace {$namespace};
            
            {$model};
            
            class {$className}Repository implements {$className}Interface
            {
                
            }
            PHP;
    }

    /**
     * @param string $projectName
     * @param string $moduleName
     * @param string $className
     * @return string
     */
    public function toModelRepositoryInterface(string $projectName, string $moduleName, string $className): string
    {
        $namespace = "App\\" . $projectName . "\\" . $moduleName . "\\Models\\Repositories";
        return <<<PHP
            <?php
            
            namespace {$namespace};
            
            interface {$className}RepositoryInterface
            {
                
            }
            PHP;
    }
}