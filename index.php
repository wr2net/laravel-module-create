<?php

require_once __DIR__ . "/vendor/autoload.php";

use App\LaravelModuleCreate\Actions\StartCreate;

$options = getopt('f:');
if (isset($options['f'])) {
    $type = $options['f'];
    $defineType = explode(":", $type);

    if (count($defineType) > 1) {
        StartCreate::create($defineType);
    }
    exit;
}
echo "\033[31mNo option provided. Use -f project:ProjectName or -f module:ProjectName:ModuleName\n\033[0m";
