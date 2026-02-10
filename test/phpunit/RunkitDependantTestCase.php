<?php

declare(strict_types=1);

namespace QratorLabs\SmockyPHPUnit\Test;

use Error;
use PHPUnit\Framework\TestCase;

use function extension_loaded;

/**
 * @internal
 */
abstract class RunkitDependantTestCase extends TestCase
{
    protected function setUp(): void
    {
        if (!extension_loaded('runkit7')) {
            // In case of missing extension, we want to be sure that tests are executed and fail with proper message
            $this->expectException(Error::class);
            $this->expectExceptionMessageMatches(
                '[^Call to undefined function runkit7_(?:function_rename|method_rename)\(\)$]'
            );
        }
        parent::setUp();
    }
}
