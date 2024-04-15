<?php

declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in(['src', 'tests'])
;

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(true)
    ->setRules([
        '@PHP80Migration:risky' => true,
        '@PHP81Migration' => true,
        '@Symfony' => true,
        '@Symfony:risky' => true,
        'blank_line_after_opening_tag' => false,
        'combine_consecutive_issets' => true,
        'combine_consecutive_unsets' => true,
        'compact_nullable_type_declaration' => true,
        'concat_space' => ['spacing' => 'one'],
        'fully_qualified_strict_types' => false, // Tries to rename variable name in GenericObjectTransformer:40
        'global_namespace_import' => [
            'import_classes' => false,
            'import_constants' => false,
            'import_functions' => false,
        ],
        'list_syntax' => ['syntax' => 'short'],
        'mb_str_functions' => true,
        'native_function_invocation' => [
            'exclude' => [],
            'include' => ['@all'],
            'scope' => 'all',
        ],
        'no_useless_else' => true,
        'no_useless_return' => true,
        'nullable_type_declaration' => ['syntax' => 'union'],
        'nullable_type_declaration_for_default_null_value' => true,
        'phpdoc_order' => true,
        'phpdoc_to_comment' => ['ignored_tags' => ['var', 'phpstan-var']],
        'static_lambda' => true,
        'strict_comparison' => true,
        'strict_param' => true,
        'types_spaces' => [
            'space_multiple_catch' => 'single',
        ],
    ])
    ->setFinder($finder)
    ->setCacheFile(__DIR__ . '/var/cache/.php_cs.cache')
;
