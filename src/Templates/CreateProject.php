<?php

namespace Wagner\LaravelModuleCreate\Templates;

use Wagner\LaravelModuleCreate\Helpers\HandleName;
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
     * @return bool
     */
    public static function createProject(string $folderName): bool
    {
        $handleName = new HandleName();
        $folderName = $handleName->handleName($folderName);

        if (file_exists(parent::BASE_FOLDER)) {
            $projectFolder = parent::BASE_FOLDER . $folderName;
            if (!file_exists(parent::BASE_FOLDER. $folderName)) {
                mkdir($projectFolder);
                return true;
            }
            return false;
        }
        return false;
    }
}