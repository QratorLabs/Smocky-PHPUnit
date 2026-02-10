<?php

/** @noinspection UsingInclusionReturnValueInspection */

declare(strict_types=1);

use Rector\CodeQuality\Rector\BooleanOr\RepeatedOrEqualToInArrayRector;
use Rector\CodeQuality\Rector\ClassConstFetch\VariableConstFetchToClassConstFetchRector;
use Rector\CodeQuality\Rector\ClassMethod\LocallyCalledStaticMethodToNonStaticRector;
use Rector\CodeQuality\Rector\Empty_\SimplifyEmptyCheckOnEmptyArrayRector;
use Rector\CodeQuality\Rector\Identical\FlipTypeControlToUseExclusiveTypeRector;
use Rector\CodeQuality\Rector\Ternary\SwitchNegatedTernaryRector;
use Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector;
use Rector\CodingStyle\Rector\ClassLike\NewlineBetweenClassLikeStmtsRector;
use Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\CodingStyle\Rector\String_\SimplifyQuoteEscapeRector;
use Rector\Config\RectorConfig;
use Rector\EarlyReturn\Rector\If_\ChangeOrIfContinueToMultiContinueRector;
use Rector\EarlyReturn\Rector\Return_\ReturnBinaryOrToEarlyReturnRector;
use Rector\EarlyReturn\Rector\StmtsAwareInterface\ReturnEarlyIfVariableRector;
use Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector;
use Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchExprVariableRector;
use Rector\Naming\Rector\Foreach_\RenameForeachValueVariableToMatchMethodCallReturnTypeRector;
use Rector\PHPUnit\CodeQuality\Rector\Class_\PreferPHPUnitThisCallRector;
use Rector\Strict\Rector\Empty_\DisallowedEmptyRuleFixerRector;
use Rector\TypeDeclaration\Rector\Class_\TypedPropertyFromCreateMockAssignRector;

$config = RectorConfig::configure();

$config->withPreparedSets(
    true,
    true,
    true,
    true,
    true,
    true,
    true,
    true,
    true,
    false,
    true,
    true,
    true,
);

$config
    ->withPaths(
        [
            './src',
            './test/phpunit',
            // './.php-cs-fixer.dist.php',
            './rector.php',
        ]
    )
    ->withSkip(
        [
            // Control
            DisallowedEmptyRuleFixerRector::class,
            FlipTypeControlToUseExclusiveTypeRector::class,

            // New lines
            NewlineAfterStatementRector::class,
            NewlineBeforeNewAssignSetRector::class,
            NewlineBetweenClassLikeStmtsRector::class,

            // Naming
            RenamePropertyToMatchTypeRector::class,
            RenameParamToMatchTypeRector::class,
            RenameVariableToMatchNewTypeRector::class,
            RenameVariableToMatchMethodCallReturnTypeRector::class,

            // PHPUnit
            PreferPHPUnitThisCallRector::class,
        ]
    )
;

return $config;
