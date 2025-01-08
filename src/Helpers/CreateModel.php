<?php

namespace Src\LaravelModuleCreate\Helpers;

class CreateModel
{
    /**
     * @param string $projectName
     * @param string $moduleName
     * @param string $className
     * @return string
     */
    public function toModel(string $projectName, string $moduleName, string $className): string
    {
        $namespace = "App\\" . $projectName . "\\" . $moduleName . "\\Models";
        $softDelete = "use App\\" . $projectName . "\\Common\\Traits\\SoftDeletes;";
        return <<<PHP
            <?php
            
            namespace {$namespace};
            
            {$softDelete}
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
            
            class {$className}Repository implements {$className}RepositoryInterface
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