<?php

    $finder = Symfony\Component\Finder\Finder::create()
        ->in([
            __DIR__ . '/src',
            __DIR__ . '/tests',
            __DIR__ . '/database',
        ])
        ->name('*.php')
        ->notName('*.blade.php')
        ->ignoreDotFiles(true)
        ->ignoreVCS(true);

    return (new PhpCsFixer\Config())
        ->setRules([
            '@PSR12' => true,
            'array_syntax' => ['syntax' => 'short'],
            'ordered_imports' => ['sort_algorithm' => 'alpha'],
            'no_unused_imports' => true,
            'trailing_comma_in_multiline' => true,
            'phpdoc_scalar' => true,
            'phpdoc_to_param_type' => true,
            'phpdoc_to_property_type' => true,
            'phpdoc_to_return_type' => true,
            'unary_operator_spaces' => true,
            'no_blank_lines_after_phpdoc' => true,
            'no_empty_phpdoc' => true,
            'phpdoc_align' => true,
            'phpdoc_indent' => true,
            'phpdoc_line_span' => true,
            'phpdoc_separation' => true,
            'phpdoc_types_order' => [
                'sort_algorithm' => 'alpha',
                'null_adjustment' => 'always_last'
            ],
            'phpdoc_types' => true,
            'phpdoc_trim_consecutive_blank_line_separation' => true,
            'phpdoc_summary' => true,
            'binary_operator_spaces' => true,
            'blank_line_before_statement' => [
                'statements' => ['break', 'continue', 'declare', 'return', 'throw', 'try'],
            ],
            'phpdoc_single_line_var_spacing' => true,
            'phpdoc_var_without_name' => true,
            'class_attributes_separation' => [
                'elements' => [
                    'method' => 'one',
                ],
            ],
            'method_argument_space' => [
                'on_multiline' => 'ensure_fully_multiline',
                'keep_multiple_spaces_after_comma' => true,
            ],
            'single_trait_insert_per_statement' => true,
        ])
        ->setFinder($finder);
