<?php

namespace Src\LaravelModuleCreate\Console\Commands;

use Illuminate\Console\Command;
use Src\LaravelModuleCreate\Actions\StartCreate;

class GenerateModuleCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lm-create:module {project} {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Module';


    public function handle(): void
    {
        $project = $this->argument('project');
        $module = $this->argument('module');
        if (!empty($project) && !empty($module)) {
            StartCreate::create(['module', $project, $module]);
            return;
        }
        echo "\033[31m Invalid arguments. Use: php artisan lm-create:module ProjectName ModuleName \n\033[0m";
    }
}