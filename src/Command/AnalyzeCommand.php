<?php
declare(strict_types=1);

namespace FrankVerhoeven\CI\Command;

use FrankVerhoeven\CI\Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('analyze', 'Run all enabled tools.')]
final class AnalyzeCommand extends Command
{
    public function __construct(
        private readonly Configuration $configuration,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addOption(
            'format',
            null,
            InputOption::VALUE_OPTIONAL,
            'Output format to use (by supported commands).',
        );
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
        $exitCode = 0;
        $application = $this->getApplication();
        \assert(null !== $application);

        foreach ($this->configuration->getEnabledTools() as $name => $_command) {
            $exitCode |= $application->find($name)->run($input, $output);
        }

        return $exitCode;
    }
}
