<?php

namespace App\LaravelModuleCreate\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\LaravelModuleCreate\Actions\StartCreate;

class StartCreateCommand extends Command
{
    /**
     * @var string
     */
    protected static string $defaultName = 'lm-create';

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setName($this::$defaultName)
            ->setDescription('Create a new Project, Module or Skeleton.')
            ->addArgument('type', InputArgument::REQUIRED, 'Operation type (eg.: skeleton:ProjectName/ModuleName)');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $type = $input->getArgument('type');
        $defineType = explode(':', $type);
        if (count($defineType) > 1) {
            StartCreate::create($defineType);
            $output->writeln('<info>Executado com sucesso!</info>');
        } else {
            $output->writeln('<error>Incorrect format. Use project:ProjectName or module:ProjectName:ModuleName</error>');
            return Command::INVALID;
        }

        return Command::SUCCESS;
    }
}