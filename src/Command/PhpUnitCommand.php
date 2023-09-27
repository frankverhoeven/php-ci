<?php
declare(strict_types=1);

namespace FrankVerhoeven\CI\Command;

use FrankVerhoeven\CI\Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Process\Process;

#[AsCommand('phpunit', 'PHPUnit')]
final class PhpUnitCommand extends CICommand
{
    protected function getProcess(InputInterface $input): Process
    {
        return new Process(
            [$this->withVendorBinPath('phpunit')],
            timeout: null,
        );
    }

    public static function isAvailable(Configuration $configuration): bool
    {
        if (!\is_file($configuration->getRootDir() . 'vendor/bin/phpunit')) {
            return false;
        }

        return \is_file($configuration->getWorkingDir() . 'phpunit.xml.dist')
            || \is_file($configuration->getWorkingDir() . 'phpunit.xml');
    }
}
