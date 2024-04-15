<?php
declare(strict_types=1);

namespace FrankVerhoeven\CI\Command;

use FrankVerhoeven\CI\Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Process\Process;

#[AsCommand('php-cs-fixer', 'PHP CS Fixer')]
final class PhpCsFixerCommand extends CICommand
{
    protected function getProcess(InputInterface $input): Process
    {
        if ($this->isGitHubFormat($input)) {
            return Process::fromShellCommandline(
                \sprintf(
                    '%s fix --diff --dry-run --format=checkstyle | cs2pr',
                    $this->withVendorBinPath('php-cs-fixer'),
                ),
                timeout: null,
            );
        }

        return new Process(
            [
                $this->withVendorBinPath('php-cs-fixer'),
                'fix',
                '--diff',
                '--dry-run',
                '--verbose',
                '--ansi',
            ],
            timeout: null,
        );
    }

    public static function isAvailable(Configuration $configuration): bool
    {
        if (!\is_file($configuration->getRootDir() . 'vendor/bin/php-cs-fixer')) {
            return false;
        }

        return \is_file($configuration->getWorkingDir() . '.php-cs-fixer.dist.php')
            || \is_file($configuration->getWorkingDir() . '.php-cs-fixer.php');
    }
}
