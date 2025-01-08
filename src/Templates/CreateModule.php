<?php

namespace Src\LaravelModuleCreate\Templates;

use Src\LaravelModuleCreate\Commons\BaseNames;
use Src\LaravelModuleCreate\Helpers\HandleHelpers;

/**
 * Class CreateModel
 * @package Src\LaravelModuleCreate\Templates
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
        $moduleName = $this->handleHelper->handleS(
            $this->handleHelper->handleName($module)
        );
        if (file_exists(parent::BASE_FOLDER . '/' . $projectName)) {
            $this->handleHelper->createDirectory(parent::BASE_FOLDER . '/' . $projectName . '/' . $moduleName);
            echo $this->handleHelper->showMessage(
                parent::BASE_FOLDER . '/' . $projectName . '/' . $moduleName,
                $moduleName
            );
        }
    }
}