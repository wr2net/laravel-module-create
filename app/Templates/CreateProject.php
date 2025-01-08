<?php

namespace App\LaravelModuleCreate\Templates;

use App\LaravelModuleCreate\Helpers\HandleHelpers;
use App\LaravelModuleCreate\Commons\BaseNames;

/**
 * Class CreateProject
 * @package App\LaravelModuleCreate\Templates
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
                $handleName->createDirectory($projectFolder);
                echo $handleName->showMessage(parent::BASE_FOLDER . $folderName, $folderName);
            }
        }
    }
}