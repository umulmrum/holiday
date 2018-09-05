<?php
$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__.'/src')
    ->in(__DIR__.'/tests')
;
$config = include __DIR__.'/vendor/chameleon-system/code-style-config/.php_cs';
return $config
    ->setFinder($finder)
;
