<?php

namespace Src\LaravelModuleCreate\Console\Commands;

use Illuminate\Console\Command;
use Src\LaravelModuleCreate\Actions\StartCreate;

class GenerateScaffoldCommand extends Command
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
    protected $signature = 'lm-create:skeleton {project} {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Scaffold';


    public function handle(): void
    {
        $project = $this->argument('project');
        $module = $this->argument('module');
        if (!empty($project) && !empty($module)) {
            StartCreate::create(['skeleton', $project, $module]);
            return;
        }
        echo "\\033[31m Invalid arguments. Use: php artisan lm-create:skeleton ProjectName ModuleName \\n\\033[0m";
    }
}