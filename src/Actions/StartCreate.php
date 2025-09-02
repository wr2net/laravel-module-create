<?php

namespace Src\LaravelModuleCreate\Actions;

use Src\LaravelModuleCreate\Helpers\HandleHelpers;
use Src\LaravelModuleCreate\Templates\CreateProject;
use Src\LaravelModuleCreate\Templates\CreateModule;
use Src\LaravelModuleCreate\Templates\CreateScaffold;

class StartCreate
{
    const DEFAULT_MESSAGE = "\033[31m Invalid option. Use -f project:ProjectName or -f module:ProjectName:ModuleName\n \033[0m";
    const PROJECT = 'project';
    const MODULE = 'module';
    const SCAFFOLD = 'skeleton';
    const BASIC_SCAFFOLD = 'basic';

    /**
     * @param array $defineType
     * @return void
     */
    public static function create(array $defineType): void
    {
        $type = $defineType[0];
        switch ($type) {
            case self::PROJECT:
                if (isset($defineType[1])) {
                    if ((new HandleHelpers)->checking($defineType[1])) {
                        (new HandleHelpers)->beginOrEnd("P", 0, $defineType[1]);
                        CreateProject::createProject($defineType[1]);
                        (new HandleHelpers)->beginOrEnd("P", 1, $defineType[1]);
                        break;
                    }
                    (new HandleHelpers)->beginOrEnd("", 0, $defineType[1]);
                    break;
                }
                echo self::DEFAULT_MESSAGE;
                break;
            case self::MODULE:
                if (isset($defineType[1]) && isset($defineType[2])) {
                    if ((new HandleHelpers)->checking($defineType[1], $defineType[2])) {
                        (new HandleHelpers)->beginOrEnd("M", 0, $defineType[2]);
                        (new CreateModule)->createFullModule($defineType[1], $defineType[2]);
                        (new HandleHelpers)->beginOrEnd("M", 1, $defineType[2]);
                        break;
                    }
                    (new HandleHelpers)->beginOrEnd("", 1, $defineType[2]);
                    break;
                }
                echo self::DEFAULT_MESSAGE;
                break;
            case self::SCAFFOLD:
                if (isset($defineType[1]) && isset($defineType[2])) {
                    (new HandleHelpers)->beginOrEnd("S", 0, $defineType[2]);
                    (new CreateScaffold)->createScaffold($defineType[1], $defineType[2], $defineType[0]);
                    (new HandleHelpers)->beginOrEnd("S", 1, $defineType[2], $defineType[1], $defineType[2]);
                    break;
                }
                echo self::DEFAULT_MESSAGE;
                break;
            case self::BASIC_SCAFFOLD:
                if (isset($defineType[1]) && isset($defineType[2])) {
                    (new HandleHelpers)->beginOrEnd("S", 0, $defineType[2]);
                    (new CreateScaffold)->createScaffold($defineType[1], $defineType[2], $defineType[0]);
                    (new HandleHelpers)->beginOrEnd("S", 1, $defineType[2], $defineType[1], $defineType[2]);
                    break;
                }
                echo self::DEFAULT_MESSAGE;
                break;
            default:
                echo self::DEFAULT_MESSAGE;
                break;
        }
    }
}