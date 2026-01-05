<?php

namespace Src\LaravelModuleCreate\Helpers;

class CreateMigration
{

    public function toMigration(string $className, array $fields): string
    {
        $tableName = (new HandleHelpers())->handleS($className);
        $name = (new HandleHelpers())->handleName($tableName);

        $useMigration = "use Illuminate\Database\Migrations\Migration;";
        $useBlueprint = "use Illuminate\Database\Schema\Blueprint;";
        $useSchema = "use Illuminate\Support\Facades\Schema;";

        $schemaFields = (new HandleHelpers())->indent($this->createSchemaFields($fields), 16);

        return <<<PHP
        <?php
            
        {$useMigration}
        {$useBlueprint}
        {$useSchema}
            
        class Create{$name}Table extends Migration
        {
            /**
            * Run the migrations.
            *
            * @return void
            */
            public function up()
            {
                Schema::create('{$tableName}', function (Blueprint \$table) {
        {$schemaFields}
                });
            }
                
            /**
            * Reverse the migrations.
            *
            * @return void
            */
            public function down()
            {
                Schema::dropIfExists('{$tableName}');
            }
        }       
        PHP;
    }

    /**
     * @param array $fields
     * @return string
     */
    private function createSchemaFields(array $fields): string
    {
        $schema = "\$table->id();";
        foreach ($fields as $field) {
            $typeField = match ($field) {
                'enabled', 'disabled', 'status' => 'boolean',
                'number', => 'integer',
                'value', 'price', 'discount' => 'float',
                default => "string",
            };
            $schema .= "\n\$table->{$typeField}('{$field}');";
        }

        $schema .= "\n\$table->timestamps();";
        $schema .= "\n\$table->softDeletes();";

        return $schema;
    }
}