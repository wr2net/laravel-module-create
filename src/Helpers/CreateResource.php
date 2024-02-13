<?php

namespace Wagner\LaravelModuleCreate\Helpers;

class CreateResource
{
    /**
     * @param string $projectName
     * @param string $moduleName
     * @param string $className
     * @return string
     */
    public function toCollection(string $projectName, string $moduleName, string $className): string
    {
        $namespace = "App\\" . $projectName . "\\" . $moduleName . "\\Resources";
        $request = '$request';

        return <<<PHP
        <?php

        namespace {$namespace};
        
        use Illuminate\Http\Request;
        use Illuminate\Http\Resources\Json\ResourceCollection;
        
        class {$className}Collection extends ResourceCollection
        {
            public function toArray({$request})
            {
                return parent::toArray({$request});
            }
        }
        PHP;
    }

    /**
     * @param string $projectName
     * @param string $moduleName
     * @param string $className
     * @return string
     */
    public function toResource(string $projectName, string $moduleName, string $className): string
    {
        $namespace = "App\\" . $projectName . "\\" . $moduleName . "\\Resources";
        $request = '$request';

        return <<<PHP
        <?php

        namespace {$namespace};
        
        use Illuminate\Http\Request;
        use Illuminate\Http\Resources\Json\JsonResource;
        
        class {$className}Resource extends JsonResource
        {
            public function toArray({$request})
            {
                return parent::toArray({$request});
            }
        }
        PHP;
    }
}