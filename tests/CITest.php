<?php
declare(strict_types=1);

namespace FrankVerhoeven\CI\Tests;

use FrankVerhoeven\CI\CI;
use FrankVerhoeven\CI\Command\AnalyzeCommand;
use FrankVerhoeven\CI\Command\CodesnifferCommand;
use FrankVerhoeven\CI\Command\DoctrineMigrationsCommand;
use FrankVerhoeven\CI\Command\DoctrineValidateSchemaCommand;
use FrankVerhoeven\CI\Command\InfectionCommand;
use FrankVerhoeven\CI\Command\LintSymfonyContainerCommand;
use FrankVerhoeven\CI\Command\LintYamlCommand;
use FrankVerhoeven\CI\Command\ListPhpVersionsCommand;
use FrankVerhoeven\CI\Command\ListToolsCommand;
use FrankVerhoeven\CI\Command\PhpStanCommand;
use FrankVerhoeven\CI\Command\PhpUnitCommand;
use FrankVerhoeven\CI\Configuration;
use PHPUnit\Framework\TestCase;

final class CITest extends TestCase
{
    private Configuration $configuration;
    private CI $CI;

    protected function setUp(): void
    {
        $this->CI = new CI(
            $this->configuration = new Configuration(),
        );
    }

    public function testGetCommands(): void
    {
        self::assertEquals(
            [
                new AnalyzeCommand($this->configuration),
                new CodesnifferCommand($this->configuration),
                new DoctrineMigrationsCommand($this->configuration),
                new DoctrineValidateSchemaCommand($this->configuration),
                new LintSymfonyContainerCommand($this->configuration),
                new LintYamlCommand($this->configuration),
                new ListToolsCommand($this->configuration),
                new ListPhpVersionsCommand($this->configuration),
                new PhpStanCommand($this->configuration),
                new PhpUnitCommand($this->configuration),
                new InfectionCommand($this->configuration),
            ],
            $this->CI->getCommands(),
        );
    }

    public function testListPhpVersion(): void
    {
        \chdir(\dirname(__DIR__));
        $phpVersions = \exec('./bin/ci list:php-versions');

        self::assertIsString($phpVersions);
        self::assertStringContainsString(\PHP_MAJOR_VERSION . '.' . \PHP_MINOR_VERSION, $phpVersions);
    }
}
