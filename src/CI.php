<?php
declare(strict_types=1);

namespace FrankVerhoeven\CI;

use FrankVerhoeven\CI\Command\AnalyzeCommand;
use FrankVerhoeven\CI\Command\CodesnifferCommand;
use FrankVerhoeven\CI\Command\DoctrineMigrationsCommand;
use FrankVerhoeven\CI\Command\DoctrineValidateSchemaCommand;
use FrankVerhoeven\CI\Command\LintSymfonyContainerCommand;
use FrankVerhoeven\CI\Command\LintYamlCommand;
use FrankVerhoeven\CI\Command\ListPhpVersionsCommand;
use FrankVerhoeven\CI\Command\ListToolsCommand;
use FrankVerhoeven\CI\Command\PhpArkitectCommand;
use FrankVerhoeven\CI\Command\PhpStanCommand;
use FrankVerhoeven\CI\Command\PhpUnitCommand;
use FrankVerhoeven\CI\Command\PsalmCommand;
use FrankVerhoeven\CI\Command\RoaveInfectionCommand;
use Symfony\Component\Console\Command\Command;

final class CI
{
    public function __construct(
        private Configuration $configuration,
    ) {
    }

    /** @return list<Command> */
    public function getCommands(): array
    {
        return [
            new AnalyzeCommand($this->configuration),
            new CodesnifferCommand($this->configuration),
            new DoctrineMigrationsCommand($this->configuration),
            new DoctrineValidateSchemaCommand($this->configuration),
            new LintSymfonyContainerCommand($this->configuration),
            new LintYamlCommand($this->configuration),
            new ListToolsCommand($this->configuration),
            new ListPhpVersionsCommand($this->configuration),
            new PhpArkitectCommand($this->configuration),
            new PhpStanCommand($this->configuration),
            new PhpUnitCommand($this->configuration),
            new PsalmCommand($this->configuration),
            new RoaveInfectionCommand($this->configuration),
        ];
    }
}
