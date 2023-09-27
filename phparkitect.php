<?php
declare(strict_types=1);

use Arkitect\ClassSet;
use Arkitect\CLI\Config;
use Arkitect\Expression\ForClasses\Extend;
use Arkitect\Expression\ForClasses\HaveNameMatching;
use Arkitect\Expression\ForClasses\ResideInOneOfTheseNamespaces;
use Arkitect\Rules\Rule;
use PHPUnit\Framework\TestCase;

return static function (Config $config): void {
    $srcClassSet = ClassSet::fromDir(__DIR__ . '/src');

    $commandNamingRule = Rule::allClasses()
        ->that(new ResideInOneOfTheseNamespaces('FrankVerhoeven\CI\Command'))
        ->should(new HaveNameMatching('*Command'))
        ->because('we want uniform naming for console commands');

    $config->add($srcClassSet, $commandNamingRule);

    $testClassSet = ClassSet::fromDir(__DIR__ . '/tests');

    $testNamingRule = Rule::allClasses()
        ->that(new Extend(TestCase::class))
        ->should(new HaveNameMatching('*Test'))
        ->because('that is a PHPUnit naming convention');

    $config->add($testClassSet, $testNamingRule);
};
