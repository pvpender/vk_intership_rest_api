<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Alias\BacktickToShellExecFixer;
use PhpCsFixer\Fixer\Alias\NoAliasLanguageConstructCallFixer;
use PhpCsFixer\Fixer\Alias\NoMixedEchoPrintFixer;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;
use PhpCsFixer\Fixer\ArrayNotation\NormalizeIndexBraceFixer;
use PhpCsFixer\Fixer\ArrayNotation\NoWhitespaceBeforeCommaInArrayFixer;
use PhpCsFixer\Fixer\ArrayNotation\TrimArraySpacesFixer;
use PhpCsFixer\Fixer\Basic\NoTrailingCommaInSinglelineFixer;
use PhpCsFixer\Fixer\Casing\ClassReferenceNameCasingFixer;
use PhpCsFixer\Fixer\Casing\IntegerLiteralCaseFixer;
use PhpCsFixer\Fixer\Casing\MagicConstantCasingFixer;
use PhpCsFixer\Fixer\Casing\MagicMethodCasingFixer;
use PhpCsFixer\Fixer\Casing\NativeFunctionCasingFixer;
use PhpCsFixer\Fixer\Casing\NativeFunctionTypeDeclarationCasingFixer;
use PhpCsFixer\Fixer\CastNotation\CastSpacesFixer;
use PhpCsFixer\Fixer\CastNotation\NoShortBoolCastFixer;
use PhpCsFixer\Fixer\Comment\NoEmptyCommentFixer;
use PhpCsFixer\Fixer\Comment\SingleLineCommentSpacingFixer;
use PhpCsFixer\Fixer\ControlStructure\EmptyLoopBodyFixer;
use PhpCsFixer\Fixer\ControlStructure\IncludeFixer;
use PhpCsFixer\Fixer\ControlStructure\SwitchContinueToBreakFixer;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\Import\FullyQualifiedStrictTypesFixer;
use PhpCsFixer\Fixer\Import\NoUnneededImportAliasFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\DeclareParenthesesFixer;
use PhpCsFixer\Fixer\NamespaceNotation\BlankLineAfterNamespaceFixer;
use PhpCsFixer\Fixer\NamespaceNotation\BlankLinesBeforeNamespaceFixer;
use PhpCsFixer\Fixer\NamespaceNotation\CleanNamespaceFixer;
use PhpCsFixer\Fixer\NamespaceNotation\NoLeadingNamespaceWhitespaceFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\ObjectOperatorWithoutWhitespaceFixer;
use PhpCsFixer\Fixer\Operator\StandardizeNotEqualsFixer;
use PhpCsFixer\Fixer\Operator\UnaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Phpdoc\AlignMultilineCommentFixer;
use PhpCsFixer\Fixer\Phpdoc\NoBlankLinesAfterPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAnnotationWithoutDotFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocVarWithoutNameFixer;
use PhpCsFixer\Fixer\PhpTag\LinebreakAfterOpeningTagFixer;
use PhpCsFixer\Fixer\Semicolon\NoEmptyStatementFixer;
use PhpCsFixer\Fixer\Semicolon\NoSinglelineWhitespaceBeforeSemicolonsFixer;
use PhpCsFixer\Fixer\StringNotation\NoBinaryStringFixer;
use PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer;
use PhpCsFixer\Fixer\Whitespace\BlankLineBeforeStatementFixer;
use PhpCsFixer\Fixer\Whitespace\NoSpacesAroundOffsetFixer;
use PhpCsFixer\Fixer\Whitespace\TypeDeclarationSpacesFixer;
use PhpCsFixer\Fixer\Whitespace\TypesSpacesFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;

return ECSConfig::configure()
    ->withPaths([
        __DIR__ . '/config',
        __DIR__ . '/public',
        __DIR__ . '/src',
    ])

    // add a single rule
    ->withRules([
        ArraySyntaxFixer::class,
        AlignMultilineCommentFixer::class,
        BacktickToShellExecFixer::class,
        BlankLineAfterNamespaceFixer::class,
        BlankLineBeforeStatementFixer::class,
        BlankLinesBeforeNamespaceFixer::class,
        BinaryOperatorSpacesFixer::class,
        CastSpacesFixer::class,
        ClassReferenceNameCasingFixer::class,
        CleanNamespaceFixer::class,
        DeclareParenthesesFixer::class,
        EmptyLoopBodyFixer::class,
        FullyQualifiedStrictTypesFixer::class,
        IncludeFixer::class,
        IntegerLiteralCaseFixer::class,
        MagicConstantCasingFixer::class,
        MagicMethodCasingFixer::class,
        LinebreakAfterOpeningTagFixer::class,
        NativeFunctionCasingFixer::class,
        NoAliasLanguageConstructCallFixer::class,
        NoBinaryStringFixer::class,
        NoBlankLinesAfterPhpdocFixer::class,
        NoEmptyCommentFixer::class,
        NoEmptyPhpdocFixer::class,
        NoEmptyStatementFixer::class,
        NoLeadingNamespaceWhitespaceFixer::class,
        NoMixedEchoPrintFixer::class,
        NoShortBoolCastFixer::class,
        NoSinglelineWhitespaceBeforeSemicolonsFixer::class,
        NoSpacesAroundOffsetFixer::class,
        NoTrailingCommaInSinglelineFixer::class,
        NoUnneededImportAliasFixer::class,
        NoUnusedImportsFixer::class,
        NoWhitespaceBeforeCommaInArrayFixer::class,
        NormalizeIndexBraceFixer::class,
        ObjectOperatorWithoutWhitespaceFixer::class,
        PhpdocAnnotationWithoutDotFixer::class,
        PhpdocVarWithoutNameFixer::class,
        SingleLineCommentSpacingFixer::class,
        SingleQuoteFixer::class,
        StandardizeNotEqualsFixer::class,
        SwitchContinueToBreakFixer::class,
        TrailingCommaInMultilineFixer::class,
        TrimArraySpacesFixer::class,
        TypeDeclarationSpacesFixer::class,
        TypesSpacesFixer::class,
        UnaryOperatorSpacesFixer::class,
    ])
    ->withPreparedSets(
        psr12: true
    )
    // add sets - group of rules
   // ->withPreparedSets(
        // arrays: true,
        // namespaces: true,
        // spaces: true,
        // docblocks: true,
        // comments: true,
    // )
     
     ;
