<?php

namespace Src\LaravelModuleCreate\Helpers;

use Src\LaravelModuleCreate\Commons\BaseNames;

class CreateReadme extends BaseNames
{
    /**
     * @param string $project
     * @param string $module
     * @param string $controller
     * @param array $fields
     * @param array $routers
     * @param string $unitTest
     * @param string $featureTest
     * @param string $migration
     * @return string
     */
    public function createReadme(
        string $project,
        string $module,
        string $controller,
        array $fields,
        array $routers,
        string $unitTest,
        string $featureTest,
        string $migration,
    ): string {

        $module = (new HandleHelpers())->handleS(
            (new HandleHelpers())->handleName($module)
        );
        $summary = "/app/{$project}/{$module}/ | [Summary](../../../README.md)";
        $whoami = exec('whoami');
        $routersList = $this->handleTableRouters($routers);
        $fieldsList = "";
        foreach ($fields as $field) {
            $fieldsList .= "- {$field}\n";
        }
        $time = date("Y-m-d H:i:s");

        $featurePatch = self::FEATURE_FOLDER;
        $unitPatch = self::UNIT_FOLDER;
        $migrationPatch = self::MIGRATION_FOLDER;

        return <<<PHP
        {$summary}
        
        ---
        # {$module}
        Created by {$whoami} on ({$time})
        
        ## Routes
        {$routersList}
        
        ## Resources
            - List: {$controller}@index
            - Create: {$controller}@store
            - Show: {$controller}@show
            - Update: {$controller}@update
            - Disable: {$controller}@disable
            - Enable: {$controller}@enable
            - Delete: {$controller}@destroy
            
        ## Tests
            - Unit: {$unitPatch}{$unitTest}
            - Feature: {$featurePatch}{$featureTest}
        
        ## Migration
            - $migrationPatch{$migration}
            
        * Need to execute: `php artisan migrate`

        ## Fields
        {$fieldsList}
        
        PHP;
    }

    /**
     * @param array $routers
     * @return string
     */
    private function handleTableRouters(array $routers): string
    {
        $routerList = "| VERB   | ENDPOINT   | METHOD   | CONTROLLER   |\n";
        $routerList .= "|-----|-----|-----|-----|\n";
        for ($r = 0; $r < count($routers); $r++) {
            $routerList .= "| {$routers[$r][0]} | {$routers[$r][1]} | {$routers[$r][2]} | {$routers[$r][3]}\n";
        }
        return $routerList;
    }
}