<?php
declare(strict_types=1);

namespace MyOnlineStore\DevTools\Command;

use MyOnlineStore\DevTools\Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('list:enabled-tools', 'Lists enabled tools (in JSON).')]
final class ListToolsCommand extends Command
{
    public function __construct(
        private readonly Configuration $configuration,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption(
            'working-dir',
            null,
            InputOption::VALUE_OPTIONAL,
            'Working directory, relative to project root.',
        );
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        if (null === $workingDir = $input->getOption('working-dir')) {
            return;
        }

        \assert(\is_string($workingDir));

        $this->configuration->setWorkingDir($workingDir);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->write(\json_encode(\array_keys($this->configuration->getEnabledTools()), \JSON_THROW_ON_ERROR));

        return 0;
    }
}
