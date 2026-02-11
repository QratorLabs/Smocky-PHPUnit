<?php

declare(strict_types=1);

namespace QratorLabs\SmockyPHPUnit;

use PHPUnit\Framework\MockObject\InvocationMocker;
use PHPUnit\Framework\MockObject\Rule\AnyInvokedCount;
use PHPUnit\Framework\MockObject\Rule\InvocationOrder;
use PHPUnit\Framework\TestCase;
use QratorLabs\Smocky\Functions\MockedFunction as GenericMockedFunction;
use ReflectionException;

use function assert;

class MockedFunction extends AbstractMocked
{
    private InvocationMocker $invocationMocker;
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

        $this->invocationMocker = $mockObject->expects($invocationRule ?? new AnyInvokedCount())->method($method);
    }

    public function callOriginal(mixed ...$args): mixed
    {
        return $this->mockedFunction->callOriginal(...$args);
    }

    public function getMocker(): InvocationMocker
    {
        return $this->invocationMocker;
    }
}
