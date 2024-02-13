<?php

namespace Wagner\LaravelModuleCreate\Templates;

use Wagner\LaravelModuleCreate\Helpers\HandleHelpers;
use Wagner\LaravelModuleCreate\Commons\BaseNames;

/**
 * Class CreateProject
 * @package Wagner\LaravelModuleCreate\Templates
 * @extends BaseNames
 */
class CreateProject extends BaseNames
{
    /**
     * @param string $folderName
     * @return void
     */
    public static function createProject(string $folderName): void
    {
        $handleName = new HandleHelpers();
        $folderName = $handleName->handleName($folderName);

        if (file_exists(parent::BASE_FOLDER)) {
            $projectFolder = parent::BASE_FOLDER . $folderName;
            if (!file_exists(parent::BASE_FOLDER. $folderName)) {
                mkdir($projectFolder);
                echo $handleName->showMessage(parent::BASE_FOLDER . $folderName, $folderName);
            }
        }
    }
}