<?php

declare(strict_types=1);

namespace QratorLabs\SmockyPHPUnit\Test;

use QratorLabs\SmockyPHPUnit\MockedFunction;
use ReflectionException;

use function QratorLabs\SmockyPHPUnit\Test\fixtures\someFunction;

final class MockedFunctionTest extends RunkitDependantTestCase
{
    /**
     * @throws ReflectionException
     */
    public function testCallOriginal(): void
    {
        /** @see someFunction */
        $function      = '\QratorLabs\SmockyPHPUnit\Test\fixtures\someFunction';
        $originalValue = $function();
        $extValue      = null;

        $mock = new MockedFunction($this, $function, $this->once());
        // This was a bit tricky: we have to use `&$mock` to maintain variable-ref but not just object-ref
        // to do proper object destruction
        $mock->getMocker()->willReturnCallback(
            static function () use (&$mock, &$extValue): string {
                $extValue = $mock->callOriginal();

                return 'someFunction';
            }
        );

        // is there any change?
        self::assertNotSame($originalValue, $function());

        // call from outside
        self::assertSame($originalValue, $mock->callOriginal());

        // call from closure
        self::assertSame($originalValue, $extValue);

        // assigment is used instead of `unset` because closure have link (ref) to mock-object
        // unsetting of local variable will not destruct object, but assigning variable to `null`
        // will do the job
        $mock = null;
        self::assertSame($originalValue, $function());
    }

    /**
     * @throws ReflectionException
     */
    public function testExpectNever(): void
    {
        $function = '\QratorLabs\SmockyPHPUnit\Test\fixtures\someFunction';
        new MockedFunction($this, $function, $this->never());
    }

    /**
     * @throws ReflectionException
     */
    public function testExpectOnce(): void
    {
        $function     = '\QratorLabs\SmockyPHPUnit\Test\fixtures\someFunction';
        $expected     = uniqid('', true);
        $functionMock = new MockedFunction($this, $function, $this->once());
        $functionMock->getMocker()->willReturn($expected);
        self::assertSame($expected, $function());
    }

    /**
     * @throws ReflectionException
     */
    public function testMinimal(): void
    {
        /** @see someFunction */
        $function    = '\QratorLabs\SmockyPHPUnit\Test\fixtures\someFunction';
        $originValue = $function();

        // @phpstan-ignore-next-line - we need to check if function in it's original state
        self::assertNotNull($originValue);
        $functionMock = new MockedFunction($this, $function);

        // @phpstan-ignore-next-line - we need to check if function in it's mocked state
        self::assertNull($function());
        unset($functionMock);
        self::assertSame($originValue, $function());
    }
}
