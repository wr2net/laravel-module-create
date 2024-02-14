<?php

namespace App\LaravelModuleCreate\Console\Commands;

use Illuminate\Console\Command;
use App\LaravelModuleCreate\Actions\StartCreate;

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


    public function handle()
    {
        $options = getopt('f:');
        if (isset($options['f'])) {
            $type = $options['f'];
            $defineType = explode(":", $type);

            if (count($defineType) > 1) {
                StartCreate::create($defineType);
            }
            exit;
        }
        echo "\033[31mNo option provided. Use create:project 'Project Name'\n\033[0m";
    }
}