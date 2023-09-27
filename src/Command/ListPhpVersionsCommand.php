<?php
declare(strict_types=1);

namespace FrankVerhoeven\CI\Command;

use FrankVerhoeven\CI\Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('list:php-versions', 'Lists PHP versions allowed by composer.json (in JSON format).')]
final class ListPhpVersionsCommand extends Command
{
    public function __construct(
        private Configuration $configuration,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->write(\json_encode($this->configuration->getPhpVersions(), \JSON_THROW_ON_ERROR));

        return 0;
    }
}
