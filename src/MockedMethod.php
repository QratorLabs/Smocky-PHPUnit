<?php

declare(strict_types=1);

namespace QratorLabs\SmockyPHPUnit;

use PHPUnit\Framework\MockObject\InvocationMocker;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Rule\InvocationOrder;
use PHPUnit\Framework\TestCase;
use QratorLabs\Smocky\ClassMethod\MockedClassMethod;
use ReflectionException;

class MockedMethod extends AbstractMocked
{
    private InvocationMocker $invocationMocker;
    private MockObject $mockObject;
    private MockedClassMethod $mockedMethod;

    /**
     * MockedMethod constructor.
     *
     * @param class-string $class
     * @param non-empty-string $method
     *
     * @throws ReflectionException
     */
    public function __construct(
        TestCase $testCase,
        string $class,
        string $method,
        ?InvocationOrder $invocationRule = null
    ) {
        $this->mockObject = self::createEmptyMock($testCase, $method);

        $mockObject         = $this->mockObject;
        $this->mockedMethod = new MockedClassMethod(
            $class,
            $method,
            /**
             * @param array<mixed> $args
             *
             * @return mixed
             * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
             */
            static function (...$args) use ($mockObject, $method) {
                return $mockObject->{$method}(...$args);
            }
        );

        $this->invocationMocker = $invocationRule === null
            ? $this->mockObject->method($method)
            : $this->mockObject->expects($invocationRule)->method($method);
    }

    /**
     * @throws ReflectionException
     */
    public function callOriginal(object $object, mixed ...$args): mixed
    {
        return $this->mockedMethod->callOriginal($object, ...$args);
    }

    /**
     * @throws ReflectionException
     */
    public function callOriginalStatic(mixed ...$args): mixed
    {
        return $this->mockedMethod->callOriginalStatic(...$args);
    }

    public function getMocker(): InvocationMocker
    {
        return $this->invocationMocker;
    }
}
