<?php

namespace Wagner\LaravelModuleCreate\Templates;

use Wagner\LaravelModuleCreate\Commons\BaseNames;
use Wagner\LaravelModuleCreate\Helpers\HandleName;


/**
 * Class CreateModule
 * @package Wagner\LaravelModuleCreate\Templates
 * @extends BaseNames
 */
class CreateModule extends BaseNames
{
    public function createFullModule(string $projectName, string $moduleName)
    {
        $this->createFolder($projectName, $moduleName);
    }

    private function createFolder($project, $module)
    {
        $handleHelper = new HandleName();
        $projectName = $handleHelper->handleName($project);
        $moduleName = $handleHelper->handleName($module);
        if (file_exists(parent::BASE_FOLDER . '/' . $projectName)) {
            mkdir(parent::BASE_FOLDER . '/' . $projectName . '/' . $moduleName);
        }
    }
}