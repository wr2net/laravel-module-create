<?php

namespace Src\LaravelModuleCreate\Helpers;

use Faker\Factory;

class CreateUnitTest
{
    /**
     * @param string $projectName
     * @param string $moduleName
     * 32
     * @param string $className
     * @param array $fields
     * @return string
     */
    public function toUnitTest(
        string $projectName, string $moduleName, string $className, array $fields = []
    ): string {
        $resource = $className;
        $testNameModule = strtolower($moduleName);
        $base = "\\App\\" . $projectName . "\\" . $moduleName . "\\";
        $namespace = "Unit";
        $model = "use " . $base . "Models\\" . $className . ";";
        $testAttributes = "use PHPUnit\Framework\Attributes\Test;";
        $testCase = "use PHPUnit\Framework\TestCase;";

        $controllerPath = "{$base}Controllers\\Api\\{$resource}Controller";
        $requestPath = "{$base}Requests\\{$resource}Request";

        $fields = $this->handleFieldsFake($fields);

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
                        ->with({$fields})
                        ->andReturn(new {$className}(['id' => 1]));
                    
                    \$controller = new {$controllerPath}(\${$testNameModule}Mock);
                    \$request = new {$requestPath}({$fields});
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
                        ->with({$fields});
                        
                    \$controller = new {$controllerPath}(\${$testNameModule}Mock);
                    \$request = new {$requestPath}({$fields});
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

    /**
     * @param array $fields
     * @return string
     */
    private function handleFieldsFake(array $fields): string
    {
        $fieldsAllocate = [];
        $faker = Factory::create();
        for ($i = 0; $i < count($fields); $i++) {
            $value = match ($fields[$i]) {
                'password' => "{$faker->password()}",
                'name' => "{$faker->words(2)}",
                'email' => "{$faker->words(1)}@example.com",
                'value','price' => $faker->randomFloat(),
                default => "{$faker->text()}",
            };
            $fieldsAllocate[] = "'{$fields[$i]}' => {$value},";
        }
        return print_r($fieldsAllocate, true);
    }
}