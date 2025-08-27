<?php

namespace Src\LaravelModuleCreate\Console\Commands;

use Illuminate\Console\Command;
use Src\LaravelModuleCreate\Actions\StartCreate;

class GenerateProjectCommand extends Command
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
    protected $signature = 'lm-create:project {project}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Project';


    public function handle(): void
    {
        $project = $this->argument('project');
        if (!empty($project)) {
            StartCreate::create(['project', $project]);
            return;
        }
        echo "\033[31m Invalid arguments. Use: php artisan lm-create:project 'Project Name' \n\033[0m";
    }
}