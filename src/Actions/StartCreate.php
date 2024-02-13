<?php

namespace Wagner\LaravelModuleCreate\Actions;

use Wagner\LaravelModuleCreate\Helpers\HandleHelpers;
use Wagner\LaravelModuleCreate\Templates\CreateProject;
use Wagner\LaravelModuleCreate\Templates\CreateModule;
use Wagner\LaravelModuleCreate\Templates\CreateScaffold;

class StartCreate
{
    const PROJECT = 'project';
    const MODULE = 'module';
    const SCAFFOLD = 'skeleton';

    /**
     * @param array $defineType
     * @return void
     */
    public static function create(array $defineType): void
    {
        $type = $defineType[0];
        switch ($type) {
            case self::PROJECT:
                (new HandleHelpers)->beginOrEnd("P", 0, $defineType[1]);
                CreateProject::createProject($defineType[1]);
                (new HandleHelpers)->beginOrEnd("P", 1, $defineType[1]);
                break;
            case self::MODULE:
                (new HandleHelpers)->beginOrEnd("M", 0, $defineType[2]);
                $module = new CreateModule;
                $module->createFullModule($defineType[1], $defineType[2]);
                (new HandleHelpers)->beginOrEnd("M", 1, $defineType[2]);
                break;
            case self::SCAFFOLD:
                (new HandleHelpers)->beginOrEnd("S", 0, $defineType[2]);
                $scaffold = new CreateScaffold;
                $scaffold->createScaffold($defineType[1], $defineType[2]);
                (new HandleHelpers)->beginOrEnd("S", 1, $defineType[2]);
                break;
            default:
                echo "Invalid option. Use -f project:ProjectName or -f module:ProjectName:ModuleName";
                break;
        }
    }
}