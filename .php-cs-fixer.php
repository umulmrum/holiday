<?php
$finder = (new PhpCsFixer\Finder())
    ->notPath('isoData.php')
    ->in(__DIR__ . '/src')
    ->in(__DIR__ . '/tests')
;

return (new PhpCsFixer\Config())
    ->setRules([
        '@PER-CS' => true,
        '@PHP82Migration' => true,
        '@PhpCsFixer' => true,
        'concat_space' => ['spacing' => 'one'],
        'global_namespace_import' => ['import_classes' => true, 'import_constants' => true, 'import_functions' => true],
        'ordered_class_elements' => false,
        'phpdoc_types_order' => ['null_adjustment' => 'always_last'],
        'php_unit_internal_class' => false,
        'php_unit_test_class_requires_covers' => false,
        'return_assignment' => false,
        'yoda_style' => false,
    ])
    ->setFinder($finder)
;
