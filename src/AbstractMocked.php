<?php

declare(strict_types=1);

namespace QratorLabs\SmockyPHPUnit;

use PHPUnit\Framework\MockObject\Generator\Generator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use QratorLabs\Smocky\EmptyClass;
use ReflectionException;

abstract class AbstractMocked
{
    /**
     * @return MockObject&EmptyClass
     * @throws ReflectionException
     */
    protected static function createEmptyMock(TestCase $testCase, string $method): MockObject
    {
        if (empty($method)) {
            throw new ReflectionException('Method name must not be empty');
        }
        /** @var MockObject&EmptyClass $mockObject */
        $mockObject = (new Generator())->testDouble(
            EmptyClass::class,
            true,
            [$method],
            [],
            '',
            false,
            false
        );

        // @phpstan-ignore-next-line instanceof.alwaysTrue
        if (!$mockObject instanceof MockObject || !$mockObject instanceof EmptyClass) {
            throw new ReflectionException('Failed to create a mock object');
        }

        $testCase->registerMockObject($mockObject);

        return $mockObject;
    }
}
