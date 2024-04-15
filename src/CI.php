<?php
declare(strict_types=1);

namespace FrankVerhoeven\CI;

use FrankVerhoeven\CI\Command\AnalyzeCommand;
use FrankVerhoeven\CI\Command\CodesnifferCommand;
use FrankVerhoeven\CI\Command\ComposerValidateCommand;
use FrankVerhoeven\CI\Command\DoctrineMigrationsCommand;
use FrankVerhoeven\CI\Command\DoctrineValidateSchemaCommand;
use FrankVerhoeven\CI\Command\InfectionCommand;
use FrankVerhoeven\CI\Command\LintSymfonyContainerCommand;
use FrankVerhoeven\CI\Command\LintYamlCommand;
use FrankVerhoeven\CI\Command\ListPhpVersionsCommand;
use FrankVerhoeven\CI\Command\ListToolsCommand;
use FrankVerhoeven\CI\Command\PhpCsFixerCommand;
use FrankVerhoeven\CI\Command\PhpStanCommand;
use FrankVerhoeven\CI\Command\PhpUnitCommand;
use Symfony\Component\Console\Command\Command;

final class CI
{
    public function __construct(
        private readonly Configuration $configuration,
    ) {
    }

    /** @return list<Command> */
    public function getCommands(): array
    {
        return [
            new AnalyzeCommand($this->configuration),
            new CodesnifferCommand($this->configuration),
            new ComposerValidateCommand($this->configuration),
            new DoctrineMigrationsCommand($this->configuration),
            new DoctrineValidateSchemaCommand($this->configuration),
            new LintSymfonyContainerCommand($this->configuration),
            new LintYamlCommand($this->configuration),
            new ListToolsCommand($this->configuration),
            new ListPhpVersionsCommand($this->configuration),
            new PhpCsFixerCommand($this->configuration),
            new PhpStanCommand($this->configuration),
            new PhpUnitCommand($this->configuration),
            new InfectionCommand($this->configuration),
        ];
    }
}
