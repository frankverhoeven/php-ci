<?php
declare(strict_types=1);

namespace FrankVerhoeven\CI\Command;

use FrankVerhoeven\CI\Configuration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Process\Process;

#[AsCommand('composer:validate', 'Composer Validate')]
final class ComposerValidateCommand extends CICommand
{
    protected function getProcess(InputInterface $input): Process
    {
        return Process::fromShellCommandline('composer validate');
    }

    public static function isAvailable(Configuration $configuration): bool
    {
        return \is_file($configuration->getRootDir() . 'composer.json');
    }
}
