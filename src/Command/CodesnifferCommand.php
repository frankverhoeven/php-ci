<?php
declare(strict_types=1);

namespace FrankVerhoeven\CI\Command;

use FrankVerhoeven\CI\Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Process\Process;

#[AsCommand('codesniffer', 'PHP_CodeSniffer')]
final class CodesnifferCommand extends CICommand
{
    protected function getProcess(InputInterface $input): Process
    {
        if ($this->isGitHubFormat($input)) {
            return Process::fromShellCommandline(
                \sprintf(
                    '%s -q --parallel=%s --report=checkstyle | cs2pr',
                    $this->withVendorBinPath('phpcs'),
                    $this->configuration->getThreads(),
                ),
                timeout: null,
            );
        }

        return new Process(
            [
                $this->withVendorBinPath('phpcs'),
                '--parallel=' . $this->configuration->getThreads(),
            ],
            timeout: null,
        );
    }

    public static function isAvailable(Configuration $configuration): bool
    {
        if (!\is_file($configuration->getRootDir() . 'vendor/bin/phpcs')) {
            return false;
        }

        return \is_file($configuration->getWorkingDir() . 'phpcs.xml.dist')
            || \is_file($configuration->getWorkingDir() . 'phpcs.xml');
    }
}
