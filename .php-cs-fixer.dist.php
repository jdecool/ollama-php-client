<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('vendor')
;

$config = new PhpCsFixer\Config();
$config
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'declare_strict_types' => true,
        'function_declaration' => ['closure_function_spacing' => 'none'],
        'single_import_per_statement' => false,
    ])
    ->setFinder($finder)
;

return $config;
