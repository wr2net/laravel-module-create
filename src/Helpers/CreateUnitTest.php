<?php

namespace Src\LaravelModuleCreate\Helpers;

class CreateUnitTest
{
    /**
     * @param string $projectName
     * @param string $moduleName
     * @param string $className
     * @return string
     */
    public function toUnitTest(string $projectName, string $moduleName, string $className): string
    {
        $resource = $className;
        $testNameModule = strtolower($moduleName);
        $base = "\\App\\" . $projectName . "\\" . $moduleName . "\\";
        $namespace = "Unit";
        $model = "use " . $base . "Models\\" . $className . ";";
        $testAttributes = "use PHPUnit\Framework\Attributes\Test;";
        $testCase = "use PHPUnit\Framework\TestCase;";

        $controllerPath = "{$base}Controllers\\Api\\{$resource}Controller";
        $requestPath = "{$base}Requests\\{$resource}Request";

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
                        ->with(['name' => ''])
                        ->andReturn(new {$className}(['id' => 1]));
                    
                    \$controller = new {$controllerPath}(\${$testNameModule}Mock);
                    \$request = new {$requestPath}(['name' => '']);
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
                        ->with(['name' => '']);
                        
                    \$controller = new {$controllerPath}(\${$testNameModule}Mock);
                    \$request = new {$requestPath}(['name' => '']);
                    \$response = \$controller->update(\$request, 1);
                    
                    \$this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, \$response);
                }
                
                #[Test]
                public function it_can_list_{$testNameModule}_unitarily()
                {
                    \${$testNameModule} = collect(
                        [
                            new {$className}(['id' => 1, 'name' => 'John Doe']),
                            new {$className}(['id' => 2, 'name' => 'John Doe']),
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
                    \${$testNameModule}s = new {$className}(['id' => 1, 'name' => 'John Doe']);
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
}