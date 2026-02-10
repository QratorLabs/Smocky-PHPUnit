<?php

declare(strict_types=1);

namespace QratorLabs\SmockyPHPUnit;

use PHPUnit\Framework\MockObject\InvocationStubber;
use PHPUnit\Framework\MockObject\Rule\InvocationOrder;
use PHPUnit\Framework\TestCase;
use QratorLabs\Smocky\Functions\MockedFunction as GenericMockedFunction;
use ReflectionException;

use function assert;

class MockedFunction extends AbstractMocked
{
    private InvocationStubber $invocationMocker;
    private GenericMockedFunction $mockedFunction;

    /**
     * @throws ReflectionException
     */
    public function __construct(
        TestCase $testCase,
        string $function,
        ?InvocationOrder $invocationRule = null
    ) {
        $mockObject = null;
        $method     = null;

        $this->mockedFunction = new GenericMockedFunction(
            $function,
            /**
             * @param array<mixed> $args
             *
             * @return mixed
             * @noinspection PhpPluralMixedCanBeReplacedWithArrayInspection
             */
            static function (...$args) use (&$mockObject, &$method) {
                return $mockObject->{$method}(...$args);
            }
        );

        $method     = $this->mockedFunction->getShortName();
        assert(!empty($method));
        $mockObject = self::createEmptyMock($testCase, $method);

        $this->invocationMocker = $invocationRule === null
            ? $mockObject->method($method)
            : $mockObject->expects($invocationRule)->method($method);
    }

    public function callOriginal(mixed ...$args): mixed
    {
        return $this->mockedFunction->callOriginal(...$args);
    }

    public function getMocker(): InvocationStubber
    {
        return $this->invocationMocker;
    }
}
