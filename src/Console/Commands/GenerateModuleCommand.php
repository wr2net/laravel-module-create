<?php

namespace App\LaravelModuleCreate\Console\Commands;

use Illuminate\Console\Command;
use App\LaravelModuleCreate\Actions\StartCreate;

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
    protected string $signature = 'lm-create:module {project} {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected string $description = 'Generate Module';


    public function handle(): void
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
        echo "\033[31m No option provided. Use create:Module ProjectName ModuleName \n\033[0m";
    }
}