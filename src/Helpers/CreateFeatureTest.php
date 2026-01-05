<?php

namespace Src\LaravelModuleCreate\Helpers;

class CreateFeatureTest
{
    /**
     * @param string $projectName
     * @param string $moduleName
     * @param string $className
     * @param array $fields
     * @param int $sizeCollection
     * @return string
     */
    public function toFeatureTest(
        string $projectName, string $moduleName, string $className, array $fields, int $sizeCollection
    ): string {
        $testNameModule = strtolower($moduleName);
        $base = "App\\" . $projectName . "\\" . $moduleName . "\\";
        $namespace = "Feature";
        $model = "use " . $base . "Models\\" . $className . ";";
        $testAttributes = "use PHPUnit\Framework\Attributes\Test;";
        $testCase = "use PHPUnit\Framework\TestCase;";

        $fieldsRow = $this->handleFields($fields);
        $dataFake = (new HandleHelpers())->iterateFields($fields);
        $dataFake = (new HandleHelpers())->indent("[\n{$dataFake}\n]", 12);
        $dataFake = ltrim(rtrim($dataFake));
        $dataStructure = $this->handleDataFake($fields, $testNameModule);
        $dataStructure = (new HandleHelpers())->indent($dataStructure, 12);
        $dataStructure = ltrim(rtrim($dataStructure));
        $validateEmailField = ltrim($this->createValidateEmailField($fields, $testNameModule)) ?? null;

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
                    \$response = \$this->getJson('/api/{$testNameModule}');
                    \$response->assertStatus(200)
                        ->assertJsonStructure([
                        'data' => [
                            '*' => {$fieldsRow},
                        ],
                    ]);
                }
                
                #[Test]
                public function it_can_create_a_{$testNameModule}_via_create_endpoint()
                {
                    \${$testNameModule}Data = {$dataFake};
                    \$response = \$this->postJson('/api/{$testNameModule}', \${$testNameModule}Data);
                    \$response->assertStatus(201)
                        ->assertJsonFragment(\${$testNameModule}Data);
                    
                    \$this->assertDatabaseHas('{$testNameModule}', \${$testNameModule}Data);
                }
                
                #[Test]
                public function it_can_show_a_{$testNameModule}_via_show_endpoint()
                {
                    \${$testNameModule} = {$className}::factory()->create();
                    \$response = \$this->getJson('/api/{$testNameModule}/' . \${$testNameModule}->id);
                    \$response->assertStatus(200)
                        ->assertJsonFragment({$dataStructure});
                }
                
                #[Test]
                public function it_can_update_a_{$testNameModule}_via_update_endpoint()
                {
                    \${$testNameModule} = {$className}::factory()->create();
                    \$updatedData = {$dataFake};
                    
                    \$response = \$this->putJson(
                        '/api/{$testNameModule}/' . \${$testNameModule}->id, \$updatedData
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
                        '/api/{$testNameModule}/' . \${$testNameModule}->id . '/enable');
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
                        '/api/{$testNameModule}/' . \${$testNameModule}->id . '/disable');
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
                    \$response = \$this->deleteJson('/api/{$testNameModule}/' . \${$testNameModule}->id);
                    \$response->assertStatus(204);
                    \$this->assertDatabaseMissing('{$testNameModule}', ['id' => \${$testNameModule}->id]);
                }
                
                #[Test]
                public function it_validates_required_fields_when_creating_{$testNameModule}()
                {
                    \$response = \$this->postJson('/api/{$testNameModule}', []);
                    \$response->assertStatus(422)
                        ->assertJsonValidationErrors(
                        {$fieldsRow}
                    );
                }
                
                #[Test]
                public function it_returns_404_when_{$testNameModule}_not_found()
                {
                    \$response = \$this->getJson('/api/{$testNameModule}/999');
                    \$response->assertStatus(404);
                }
                
                #[Test]
                public function it_can_paginate_{$testNameModule}_list()
                {
                    Client::factory()->count(15)->create();
            
                    \$response = \$this->getJson('/api/{$testNameModule}?per_page=10');
                    \$response->assertStatus(200)
                        ->assertJsonStructure([
                            'data',
                            'meta' => ['current_page', 'total', 'per_page']
                        ])
                        ->assertJsonCount(10, 'data');
                }
                
                #[Test]
                public function it_can_filter_{$testNameModule}_by_status()
                {
                    {$moduleName}::factory()->count(2)->create(['status' => 'enabled']);
                    {$moduleName}::factory()->count(3)->create(['status' => 'disabled']);
            
                    \$response = \$this->getJson('/api/{$testNameModule}?status=enabled');
            
                    \$response->assertStatus(200)
                        ->assertJsonCount(2, 'data');
                }
                
                {$validateEmailField}
            }

            PHP;
    }

    /**
     * @param array $fields
     * @return string
     */
    private function handleFields(array $fields): string
    {
        $list = "['id',";
        foreach ($fields as $field) {
            $list .= "'{$field}', ";
        }
        $list .= "]";
        return $list;
    }

    private function handleDataFake(array $fields, string $testNameModule): string
    {
        $row = "[";
        $row .= "\n'id' => \${$testNameModule}->id,";
        foreach ($fields as $field) {
            $row .= "\n'{$field}' => \${$testNameModule}->{$field},";
        }

        return $row . "\n]";
    }

    private function createValidateEmailField(
        array $fields, string $testNameModule
    ): string {
        $hasEmailField = in_array('email', $fields);
        if (!$hasEmailField) {
            return '';
        }

        return "\n" . '
        #[Test]' . "\n    " . 'public function it_validates_email_format_when_creating_' .
            $testNameModule . '()' . "\n    " . '{
        $response = $this->postJson(
            \'/api/' . $testNameModule . '\',
            [
                \'name\' => \'John Doe\',
                \'email\' => \'invalid-email\',
                \'status\' => \'enabled\'
            ]
        );

        $response->assertStatus(422)
            ->assertJsonValidationErrors([\'email\']);
    }';
    }
}