<?php

declare(strict_types=1);

use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenDefineFunctions;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenFinalClasses;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenNormalClasses;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenPrivateMethods;
use NunoMaduro\PhpInsights\Domain\Insights\ForbiddenTraits;
use NunoMaduro\PhpInsights\Domain\Metrics\Architecture\Classes;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Arrays\ArrayIndentSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Arrays\DisallowLongArraySyntaxSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Files\LineLengthSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Formatting\SpaceAfterCastSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\NamingConventions\UpperCaseConstantNameSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\LowerCaseConstantSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\LowerCaseKeywordSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\PHP\LowerCaseTypeSniff;
use PHP_CodeSniffer\Standards\Generic\Sniffs\VersionControl\GitMergeConflictSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\Strings\DoubleQuoteUsageSniff;
use SlevomatCodingStandard\Sniffs\Arrays\DisallowImplicitArrayCreationSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\DisallowEmptySniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\DisallowShortTernaryOperatorSniff;
use SlevomatCodingStandard\Sniffs\Functions\UnusedParameterSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\DeclareStrictTypesSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\DisallowMixedTypeHintSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\ParameterTypeHintSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\PropertyTypeHintSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\ReturnTypeHintSniff;
use PHP_CodeSniffer\Standards\PSR1\Sniffs\Classes\ClassDeclarationSniff;
use PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\FunctionSpacingSniff;
use PhpCsFixer\Fixer\Comment\NoEmptyCommentFixer;
use SlevomatCodingStandard\Sniffs\Classes\EmptyLinesAroundClassBracesSniff;
use SlevomatCodingStandard\Sniffs\Classes\ForbiddenPublicPropertySniff;
use SlevomatCodingStandard\Sniffs\Classes\PropertySpacingSniff;
use SlevomatCodingStandard\Sniffs\Classes\SuperfluousExceptionNamingSniff;
use SlevomatCodingStandard\Sniffs\Classes\TraitUseDeclarationSniff;
use SlevomatCodingStandard\Sniffs\Classes\TraitUseSpacingSniff;
use SlevomatCodingStandard\Sniffs\Commenting\DisallowCommentAfterCodeSniff;
use SlevomatCodingStandard\Sniffs\Commenting\DisallowOneLinePropertyDocCommentSniff;
use SlevomatCodingStandard\Sniffs\Commenting\EmptyCommentSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\AssignmentInConditionSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\BlockControlStructureSpacingSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\EarlyExitSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\JumpStatementsSpacingSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\NewWithoutParenthesesSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\RequireMultiLineConditionSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\RequireMultiLineTernaryOperatorSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\RequireSingleLineConditionSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\RequireTernaryOperatorSniff;
use SlevomatCodingStandard\Sniffs\ControlStructures\RequireYodaComparisonSniff;
use SlevomatCodingStandard\Sniffs\Files\TypeNameMatchesFileNameSniff;
use SlevomatCodingStandard\Sniffs\Functions\ArrowFunctionDeclarationSniff;
use SlevomatCodingStandard\Sniffs\Functions\DisallowArrowFunctionSniff;
use SlevomatCodingStandard\Sniffs\Functions\DisallowTrailingCommaInCallSniff;
use SlevomatCodingStandard\Sniffs\Functions\FunctionLengthSniff;
use SlevomatCodingStandard\Sniffs\Functions\RequireArrowFunctionSniff;
use SlevomatCodingStandard\Sniffs\Functions\RequireMultiLineCallSniff;
use SlevomatCodingStandard\Sniffs\Functions\RequireSingleLineCallSniff;
use SlevomatCodingStandard\Sniffs\Functions\RequireTrailingCommaInCallSniff;
use SlevomatCodingStandard\Sniffs\Functions\StaticClosureSniff;
use SlevomatCodingStandard\Sniffs\Functions\StrictCallSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\AlphabeticallySortedUsesSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\FullyQualifiedClassNameInAnnotationSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\FullyQualifiedExceptionsSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\FullyQualifiedGlobalConstantsSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\FullyQualifiedGlobalFunctionsSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\ReferenceUsedNamesOnlySniff;
use SlevomatCodingStandard\Sniffs\Namespaces\UnusedUsesSniff;
use SlevomatCodingStandard\Sniffs\Namespaces\UseOnlyWhitelistedNamespacesSniff;
use SlevomatCodingStandard\Sniffs\Numbers\RequireNumericLiteralSeparatorSniff;
use SlevomatCodingStandard\Sniffs\Operators\DisallowEqualOperatorsSniff;
use SlevomatCodingStandard\Sniffs\Operators\DisallowIncrementAndDecrementOperatorsSniff;
use SlevomatCodingStandard\Sniffs\Operators\RequireOnlyStandaloneIncrementAndDecrementOperatorsSniff;
use SlevomatCodingStandard\Sniffs\PHP\DisallowReferenceSniff;
use SlevomatCodingStandard\Sniffs\PHP\RequireExplicitAssertionSniff;
use SlevomatCodingStandard\Sniffs\TypeHints\DisallowArrayTypeHintSyntaxSniff;
use SlevomatCodingStandard\Sniffs\Whitespaces\DuplicateSpacesSniff;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Preset
    |--------------------------------------------------------------------------
    |
    | This option controls the default preset that will be used by PHP Insights
    | to make your code reliable, simple, and clean. However, you can always
    | adjust the `Metrics` and `Insights` below in this configuration file.
    |
    | Supported: "default", "laravel", "symfony", "magento2", "drupal"
    |
    */

    'preset' => 'laravel',

    /*
    |--------------------------------------------------------------------------
    | IDE
    |--------------------------------------------------------------------------
    |
    | This options allow to add hyperlinks in your terminal to quickly open
    | files in your favorite IDE while browsing your PhpInsights report.
    |
    | Supported: "textmate", "macvim", "emacs", "sublime", "phpstorm",
    | "atom", "vscode".
    |
    | If you have another IDE that is not in this list but which provide an
    | url-handler, you could fill this config with a pattern like this:
    |
    | myide://open?url=file://%f&line=%l
    |
    */

    'ide' => 'phpstorm',

    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may adjust all the various `Insights` that will be used by PHP
    | Insights. You can either add, remove or configure `Insights`. Keep in
    | mind that all added `Insights` must belong to a specific `Metric`.
    |
    */

    'exclude' => [
        'docker',
        'storage',
        'lang',
        '*.phpstorm.meta.php',
        '*_ide_helper.php',
        '*.js',
        '*.css',
        '*.xml',
        '*.blade.php',
        'autoload.php',
    ],

    'add' => [
        Classes::class => [
            ForbiddenFinalClasses::class,
            DisallowLongArraySyntaxSniff::class,
            ArrayIndentSniff::class,
            SpaceAfterCastSniff::class,
            LowerCaseConstantSniff::class,
            LowerCaseKeywordSniff::class,
            LowerCaseTypeSniff::class,
            UpperCaseConstantNameSniff::class,
            GitMergeConflictSniff::class,
            DoubleQuoteUsageSniff::class,
        ],
    ],

    'remove' => [
        AlphabeticallySortedUsesSniff::class,
        DeclareStrictTypesSniff::class,
        DisallowMixedTypeHintSniff::class,
        ForbiddenDefineFunctions::class,
        ForbiddenNormalClasses::class,
        ForbiddenTraits::class,
        PropertyTypeHintSniff::class,
        ParameterTypeHintSniff::class,

        DeclareStrictTypesSniff::class,
        DisallowArrayTypeHintSyntaxSniff::class,
        DisallowMixedTypeHintSniff::class,
        FunctionLengthSniff::class,

        StaticClosureSniff::class,
        DisallowArrowFunctionSniff::class,
        RequireArrowFunctionSniff::class,
        RequireTrailingCommaInCallSniff::class,
        DisallowTrailingCommaInCallSniff::class,
        StrictCallSniff::class,
        RequireSingleLineCallSniff::class,
        UnusedParameterSniff::class,

        FullyQualifiedGlobalFunctionsSniff::class,
        FullyQualifiedGlobalConstantsSniff::class,
        FullyQualifiedClassNameInAnnotationSniff::class,
        FullyQualifiedExceptionsSniff::class,
        UseOnlyWhitelistedNamespacesSniff::class,

        NewWithoutParenthesesSniff::class,
        RequireMultiLineTernaryOperatorSniff::class,
        RequireTernaryOperatorSniff::class,
        DisallowShortTernaryOperatorSniff::class,
        BlockControlStructureSpacingSniff::class,
        JumpStatementsSpacingSniff::class,
        RequireYodaComparisonSniff::class,
        AssignmentInConditionSniff::class,
        DisallowEmptySniff::class,
        RequireSingleLineConditionSniff::class,
        EarlyExitSniff::class,
        NoEmptyCommentFixer::class,

        RequireExplicitAssertionSniff::class,
        DisallowReferenceSniff::class,

        TraitUseDeclarationSniff::class,
        ForbiddenPublicPropertySniff::class,
        SuperfluousExceptionNamingSniff::class,

        EmptyCommentSniff::class,
        DisallowOneLinePropertyDocCommentSniff::class,
        DisallowCommentAfterCodeSniff::class,

        RequireNumericLiteralSeparatorSniff::class,

        DisallowEqualOperatorsSniff::class,
        DisallowIncrementAndDecrementOperatorsSniff::class,
        RequireOnlyStandaloneIncrementAndDecrementOperatorsSniff::class,

        DisallowImplicitArrayCreationSniff::class,
    ],

    'config' => [
        ForbiddenPrivateMethods::class => [
            'title' => 'The usage of private methods is not idiomatic in Laravel.',
        ],
        FunctionSpacingSniff::class => [
            'spacing' => 1,
            'spacingBeforeFirst' => 0,
            'spacingAfterLast' => 0,
        ],
        UnusedUsesSniff::class => [
            'searchAnnotations' => true,
        ],
        ReferenceUsedNamesOnlySniff::class => [
            'allowFullyQualifiedGlobalClasses' => true,
            'exclude' => [
                'config/*',
                'app/Http/Kernel.php',
            ],
        ],
        TraitUseSpacingSniff::class => [
            'linesCountBeforeFirstUse' => 0,
            'linesCountBeforeFirstUseWhenFirstInClass' => 0,
            'linesCountBetweenUses' => 0,
            'linesCountAfterLastUse' => 1,
            'linesCountAfterLastUseWhenLastInClass' => 0
        ],
        EmptyLinesAroundClassBracesSniff::class => [
            'linesCountAfterOpeningBrace' => 0,
            'linesCountBeforeClosingBrace' => 0,
        ],
        PropertySpacingSniff::class => [
            'minLinesCountBeforeWithComment' => 0,
            'maxLinesCountBeforeWithComment' => 1,
            'minLinesCountBeforeWithoutComment' => 0,
            'maxLinesCountBeforeWithoutComment' => 1
        ],
        TypeNameMatchesFileNameSniff::class => [
            'rootNamespaces' => [
                'app' => 'App',
                'tests' => 'Tests',
            ],
            'exclude' => [
                'database/migrations/*',
            ],
        ],
        LineLengthSniff::class => [
            'lineLimit' => 160,
            'absoluteLineLimit' => 160,
            'ignoreComments' => true,
        ],
        RequireMultiLineCallSniff::class => [
            'minLineLength' => 160,
        ],
        ArrowFunctionDeclarationSniff::class => [
            'spacesCountAfterKeyword' => 0,
        ],
        RequireMultiLineConditionSniff::class => [
            'minLineLength' => 140,
        ],
        DuplicateSpacesSniff::class => [
            'ignoreSpacesInAnnotation' => true,
            'ignoreSpacesInComment' => true,
        ],
        ClassDeclarationSniff::class => [
            'exclude' => [
                'database/migrations/*',
            ],
        ],
        UnusedParameterSniff::class => [
            'exclude' => [
                'app/Console/Kernel.php',
                'app/Exceptions/Handler.php',
            ],
        ],
        ReturnTypeHintSniff::class => [
            'exclude' => [
                'routes/web.php',
                'routes/api.php',
            ],
        ],
        ParameterTypeHintSniff::class => [
            'exclude' => [
                'app/Http/Middleware/Authenticate.php',
            ],
        ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Requirements
    |--------------------------------------------------------------------------
    |
    | Here you may define a level you want to reach per `Insights` category.
    | When a score is lower than the minimum level defined, then an error
    | code will be returned. This is optional and individually defined.
    |
    */

    'requirements' => [
        'min-quality' => 100,
        'min-complexity' => 85,
        'min-architecture' => 100,
        'min-style' => 100,
        'disable-security-check' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Threads
    |--------------------------------------------------------------------------
    |
    | Here you may adjust how many threads (core) PHPInsights can use to perform
    | the analyse. This is optional, don't provide it and the tool will guess
    | the max core number available. This accept null value or integer > 0.
    |
    */

    'threads' => null,

];
