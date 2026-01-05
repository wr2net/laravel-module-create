<?php

namespace Src\LaravelModuleCreate\Helpers;


class CreateUnitTest
{
    /**
     * @param string $projectName
     * @param string $moduleName
     * @param string $className
     * @param array $fields
     * @param int $sizeCollection
     * @return string
     */
    public function toUnitTest(
        string $projectName, string $moduleName, string $className, array $fields, int $sizeCollection = 3
    ): string {
        $resource = $className;
        $testNameModule = strtolower($moduleName);
        $base = "App\\" . $projectName . "\\" . $moduleName . "\\";
        $namespace = "Unit";
        $model = "use " . $base . "Models\\" . $className . ";";
        $testAttributes = "use PHPUnit\Framework\Attributes\Test;";
        $testCase = "use PHPUnit\Framework\TestCase;";

        $controllerPath = "{$base}Controllers\\Api\\{$resource}Controller";
        $requestPath = "{$base}Requests\\{$resource}Request";

        $fieldsRows = $this->handleFieldsFakeWithId($fields, $sizeCollection);
        $collection = rtrim($this->handleCollection($className, $fieldsRows, $sizeCollection));
        $oneRowCollection = rtrim((new HandleHelpers())->indent(ltrim(rtrim($fieldsRows[0])), 8));
        $fieldsRow = rtrim($this->handleFieldsFake($fields));
        $end = (new HandleHelpers())->indent("\n]", 8);
        $end = str_replace("\n", "", $end);
        $fieldsRow = $fieldsRow . "\n" . $end;

        return <<<PHP
            <?php
            
            namespace {$namespace};

            {$model}
            {$testAttributes}
            {$testCase}
            
            class {$className}UnitTest extends TestCase
            {
                #[Test]
                public function it_can_create_{$testNameModule}_unitarily()
                {
                    \${$testNameModule}Mock = \$this->mock({$resource}::class);
                    \${$testNameModule}Mock->shouldReceive('create')
                        ->once()
                        ->with({$fieldsRow})
                        ->andReturn(new {$className}(['id' => 1]));
                    
                    \$controller = new {$controllerPath}(\${$testNameModule}Mock);
                    \$request = new {$requestPath}({$fieldsRow});
                    \$response = \$controller->store(\$request);
                    
                    \$this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, \$response);   
                }
                
                #[Test]
                public function it_can_update_{$testNameModule}_unitarily()
                {
                    \${$testNameModule}Mock = \$this->mock({$resource}::class);
                    \${$testNameModule}Mock->shouldReceive('findOrFail')
                        ->with(1)
                        ->andReturn(\${$testNameModule}Mock);
                        
                    \${$testNameModule}Mock->shouldReceive('update')
                        ->once()
                        ->with({$fieldsRow});
                        
                    \$controller = new {$controllerPath}(\${$testNameModule}Mock);
                    \$request = new {$requestPath}({$fieldsRow});
                    \$response = \$controller->update(\$request, 1);
                    
                    \$this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, \$response);
                }
                
                #[Test]
                public function it_can_list_{$testNameModule}_unitarily()
                {
                    \${$testNameModule} = collect(
                        [
            {$collection}
                        ]
                    );
                    
                    \${$testNameModule}Mock = \$this->mock({$resource}::class);
                    \${$testNameModule}Mock->shouldReceive('all')
                        ->with(1)
                        ->andReturn(\${$testNameModule});
                        
                    \$controller = new {$controllerPath}(\${$testNameModule}Mock);
                    \$response = \$controller->index();
                    
                    \$this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, \$response);
                }
                
                #[Test]
                public function it_can_show_{$testNameModule}_unitarily()
                {
                    \${$testNameModule}s = new {$className}({$oneRowCollection});
                    \${$testNameModule}Mock = \$this->mock({$resource}::class);
                    \${$testNameModule}Mock->shouldReceive('findOrFail')
                        ->with(1)
                        ->andReturn(\${$testNameModule}s);
                        
                    \$controller = new {$controllerPath}(\${$testNameModule}Mock);
                    \$response = \$controller->show(1);
                    
                    \$this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, \$response);
                }
                
                #[Test]
                public function it_can_enable_{$testNameModule}_unitarily()
                {
                    \${$testNameModule}Mock = \$this->mock({$resource}::class);
                    \${$testNameModule}Mock->shouldReceive('findOrFail')
                        ->with(1)
                        ->andReturn(\${$testNameModule}Mock);
                    \${$testNameModule}Mock->shouldReceive('update')
                        ->once()
                        ->with(['status' => 'enabled']);
                    \$controller = new {$controllerPath}(\${$testNameModule}Mock);
                    \$response = \$controller->enable(1);
                    
                    \$this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, \$response);
                }
                
                #[Test]
                public function it_can_disable_{$testNameModule}_unitarily()
                {
                    \${$testNameModule}Mock = \$this->mock({$resource}::class);
                    \${$testNameModule}Mock->shouldReceive('findOrFail')
                        ->with(1)
                        ->andReturn(\${$testNameModule}Mock);
                    \${$testNameModule}Mock->shouldReceive('update')
                        ->once()
                        ->with(['status' => 'disabled']);
                    \$controller = new {$controllerPath}(\${$testNameModule}Mock);
                    \$response = \$controller->disable(1);
                    
                    \$this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, \$response);
                }
                
                #[Test]
                public function it_can_delete_{$testNameModule}_unitarily()
                {
                    \${$testNameModule}Mock = \$this->mock({$resource}::class);
                    \${$testNameModule}Mock->shouldReceive('findOrFail')
                        ->with(1)
                        ->andReturn(\${$testNameModule}Mock);
                    \${$testNameModule}Mock->shouldReceive('delete')
                        ->once();
                    \$controller = new {$controllerPath}(\${$testNameModule}Mock);
                    \$response = \$controller->delete(1);
                    
                    \$this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, \$response);                
                }
            }
            PHP;
    }

    /**
     * @param array $fields
     * @return string
     */
    private function handleFieldsFake(array $fields): string
    {
        $start = "[\n";
        $fieldsAllocate = (new HandleHelpers())->indent(
            (new HandleHelpers())->iterateFields($fields)
            , 20
        );
        return $start . rtrim($fieldsAllocate);
    }

    /**
     * @param array $fields
     * @param int $size
     * @return array
     */
    private function handleFieldsFakeWithId(array $fields, int $size = 1): array
    {
        $rows = [];
        for ($s = 1; $s <= $size; $s++) {
            $fieldsAllocate = "[\n'id' => {$s},";
            $fieldsAllocate .= ltrim(rtrim((new HandleHelpers())->iterateFields($fields)));
            $fieldsAllocate = (new HandleHelpers())->indent($fieldsAllocate);
            $fieldsAllocate .= "\n]";
            $rows[] = $fieldsAllocate;
        }

        return $rows;
    }

    /**
     * @param string $className
     * @param array $fieldsRows
     * @param int $sizeCollection
     * @return string
     */
    private function handleCollection(string $className, array $fieldsRows, int $sizeCollection): string
    {
        $collection = '';
        for ($c = 0; $c < $sizeCollection; $c++) {
            if ($c > 0) {
                $collection .= "\n";
            }
            $collection .= 'new ' . $className . '(' . rtrim(ltrim($fieldsRows[$c])) . '),';
        }
        return (new HandleHelpers())->indent($collection, 16);
    }
}