<?php
declare(strict_types=1);

namespace MyOnlineStore\DevTools\Command;

use MyOnlineStore\DevTools\Configuration;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Process\Process;

final class PhpStanCommand extends DevToolsCommand
{
    /** @var string|null */
    protected static $defaultName = 'phpstan';

    /** @var string|null */
    protected static $defaultDescription = 'PHPStan';

    protected function getProcess(InputInterface $input): Process
    {
        $command = [
            $this->withVendorBinPath('phpstan'),
        ];

        if ($this->isGitHubFormat($input)) {
            $command[] = '--error-format=github';
        }

        return new Process($command, timeout: null);
    }

    public static function isAvailable(Configuration $configuration): bool
    {
        return \is_file($configuration->getRootDir() . 'phpstan.neon.dist')
            || \is_file($configuration->getRootDir() . 'phpstan.neon');
    }
}
