<?php

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\FunctionNotation\ReturnTypeDeclarationFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DeclareEqualNormalizeFixer;
use PhpCsFixer\Fixer\Operator\ConcatSpaceFixer;
use PhpCsFixer\Fixer\Operator\IncrementStyleFixer;
use Symplify\CodingStandard\Fixer\LineLength\LineLengthFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $ecsConfig): void {
    $ecsConfig->paths([__DIR__.'/src', __DIR__.'/tests']);

    // A. full sets
    $ecsConfig->sets([SetList::PSR_12]);

    // B. standalone rule
    $ecsConfig->ruleWithConfiguration(ArraySyntaxFixer::class, [
        'syntax' => 'short',
    ]);

    $ecsConfig->rule(DeclareEqualNormalizeFixer::class);

    $ecsConfig->rule(ReturnTypeDeclarationFixer::class);

    $ecsConfig->rule(NoUnusedImportsFixer::class);

    $ecsConfig->ruleWithConfiguration(ConcatSpaceFixer::class, [
        'spacing' => 'none'
    ]);

    $ecsConfig->ruleWithConfiguration(IncrementStyleFixer::class, [
                    'style' => 'pre',
                ]);

    $ecsConfig->ruleWithConfiguration(LineLengthFixer::class, [
            'max_line_length' => 160,
            'break_long_lines' => true,
            'inline_short_lines' => false,
        ]);
};
