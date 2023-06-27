<?php

require_once __DIR__ . "/vendor/autoload.php";

use Wagner\LaravelModuleCreate\Templates\CreateProject;
use Wagner\LaravelModuleCreate\Templates\CreateModule;

const PROJECT = 'project';

$projectName = "";
$moduleName = "";

$args = getopt('f:');
$type = $args['f'];
$defineType = explode(":", $type);

if (sizeof($defineType) > 1) {
    $moduleName = $defineType[1];
    $projectName = $defineType[1];
    if ($defineType[0] != PROJECT) {
        $projectName = $defineType[0];
    }
    $type = $defineType[0];
}

switch ($type) {
    case PROJECT:
        CreateProject::createProject($projectName);
        break;
    default:
        $module = new CreateModule;
        $module->createFullModule($projectName, $moduleName);
        break;
}