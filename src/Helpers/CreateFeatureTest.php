<?php

namespace Src\LaravelModuleCreate\Helpers;

class CreateFeatureTest
{

    public function toFeatureTest(string $projectName, string $moduleName, string $className): string
    {
        $resource = $className;
        $testNameModule = strtolower($moduleName);
        $base = "\\App\\" . $projectName . "\\" . $moduleName . "\\";
        $namespace = "Feature";
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
            
            class {$className}FeatureTest extends TestCase
            {
                #[Test]
                public function it_can_list_{$testNameModule}_via_index_endpoint()
                {
                    {$className}::factory()->count(3)->create();
                    \$response = \$this->getJson('/api/{$moduleName}/{$testNameModule}');
                    \$response->assertStatus(200)
                        ->assertJsonStructure([
                        'data' => [
                            '*' => ['id', 'name', 'email', 'status'],
                        ],
                    ]);
                }
                
                #[Test]
                public function it_can_create_a_{$testNameModule}_via_create_endpoint()
                {
                    \${$testNameModule}Data = [
                        'name' => 'John Doe',
                        'email' => 'john@example.com',
                        'status' => 'enabled',
                    ];
                    \$response = \$this->postJson('/api/{$moduleName}/{$testNameModule}', \${$testNameModule}Data);
                    \$response->assertStatus(201)
                        ->assertJsonFragment(\${$testNameModule}Data);
                    
                    \$this->assertDatabaseHas('{$testNameModule}', \${$testNameModule}Data);
                }
                
                #[Test]
                public function it_can_show_a_{$testNameModule}_via_show_endpoint()
                {
                    \${$testNameModule} = {$className}::factory()->create();
                    \$response = \$this->getJson('/api/{$testNameModule}/{\${$testNameModule}->id}');
                    \$response->assertStatus(200)
                        ->assertJsonFragment([
                            'id' => \${$testNameModule}->id,
                            'name' => \${$testNameModule}->name,
                            'email' => \${$testNameModule}->email,
                            'status' => \${$testNameModule}->status,
                    ]);
                }
                
                #[Test]
                public function it_can_update_a_{$testNameModule}_via_update_endpoint()
                {
                    \${$testNameModule} = {$className}::factory()->create();
                    \$updatedData = [
                        'name' => 'Jane Doe',
                        'email' => 'jane@example.com',
                        'status' => 'disabled',
                    ];
                    
                    \$response = \$this->putJson(
                        '/api/{$moduleName}/{$testNameModule}/{\${$testNameModule}->id}', \$updatedData
                    );
                    \$response->assertStatus(200)
                        ->assertJsonFragment(\$updatedData);
                    
                    \$this->assertDatabaseHas('{$testNameModule}', array_merge(
                        ['id' => \${$testNameModule}->id],
                        \$updatedData
                    ));
                }
                
                #[Test]
                public function it_can_enable_a_{$testNameModule}_via_enable_endpoint()
                {
                    \${$testNameModule} = {$className}::factory()->create(['status' => 'disabled']);
                    \$response = \$this->putJson(
                        '/api/{$testNameModule}/{\${$testNameModule}->id}/enable');
                    \$response->assertStatus(200)
                        ->assertJsonFragment(['status' => 'enabled']);
                    
                    \$this->assertDatabaseHas(
                        '{$testNameModule}',
                        [
                            'id' => \${$testNameModule}->id,
                            'status' => 'enabled',
                        ]
                    );
                }
                
                #[Test]
                public function it_can_disable_a_{$testNameModule}_via_disable_endpoint()
                {
                    \${$testNameModule} = {$className}::factory()->create(['status' => 'enable']);
                    \$response = \$this->putJson(
                        '/api/{$testNameModule}/{\${$testNameModule}->id}/disable');
                    \$response->assertStatus(200)
                        ->assertJsonFragment(['status' => 'disabled']);
                    
                    \$this->assertDatabaseHas(
                        '{$testNameModule}',
                        [
                            'id' => \${$testNameModule}->id,
                            'status' => 'sidabled',
                        ]
                    );
                }
                
                #[Test]
                public function it_can_delete_a_{$testNameModule}_via_delete_endpoint()
                {
                    \${$testNameModule} = {$className}::factory()->create();
                    \$response = \$this->deleteJson('/api/{$testNameModule}/{\${$testNameModule}->id}');
                    \$response->assertStatus(204);
                    \$this->assertDatabaseMissing('{$testNameModule}', ['id' => \${$testNameModule}->id]);
                }
                
                #[Test]
                public function it_validates_required_fields_when_creating_{$testNameModule}()
                {
                    \$response = \$this->postJson('/api/{$testNameModule}', []);
                    \$response->assertStatus(422)
                        ->assertJsonValidationErrors(['name', 'email']);
                }
            }

            PHP;
    }
}