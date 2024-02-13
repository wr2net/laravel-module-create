<?php

namespace Wagner\LaravelModuleCreate\Templates;

use Wagner\LaravelModuleCreate\Commons\BaseNames;
use Wagner\LaravelModuleCreate\Helpers\HandleHelpers;


/**
 * Class CreateModel
 * @package Wagner\LaravelModuleCreate\Templates
 * @extends BaseNames
 */
class CreateModule extends BaseNames
{
    /**
     * @var HandleHelpers
     */
    private HandleHelpers $handleHelper;

    public function __construct()
    {
        $this->handleHelper = new HandleHelpers();
    }

    /**
     * @param string $projectName
     * @param string $moduleName
     * @return void
     */
    public function createFullModule(string $projectName, string $moduleName): void
    {
        $this->createFolder($projectName, $moduleName);
    }

    /**
     * @param $project
     * @param $module
     * @return void
     */
    private function createFolder($project, $module): void
    {
        $projectName = $this->handleHelper->handleName($project);
        $moduleName = $this->handleHelper->handleName($module);
        if (file_exists(parent::BASE_FOLDER . '/' . $projectName)) {
            mkdir(parent::BASE_FOLDER . '/' . $projectName . '/' . $moduleName);
            echo $this->handleHelper->showMessage(
                parent::BASE_FOLDER . '/' . $projectName . '/' . $moduleName,
                $moduleName
            );
        }
    }
}