# QratorLabs\Smocky-PHPUnit

This is a helper library-helper for QratorLabs\Smocky
that allows you to use Smocky and PHPUnit together with less boilerplate code.

## Installation

```bash
composer require --dev "qratorlabs/smocky-phpunit:^1.0||^2.0"
```

## Versioning

This library follows [SemVer](https://semver.org/).
But major versions are used to indicate compatibility with PHPUnit versions:
- `1.x` is compatible with PHPUnit 9.6...12.0.8
- `2.0` is compatible with PHPUnit 12.0.9...12.4.x
- `2.1` is compatible with PHPUnit 12.5.0...
- `2.2` is compatible with PHPUnit 13.0.0...

## Usage
To use with PHPUnit:
  - `MockedMethod` to mock method "globally" and use PHPUnit's `*Mockers` - `expects/willReturn/willReturnCallback/...`
  - `MockedFunction` 
## MockedMethod

The main target is to make mocking static methods easy and feels-n-looks like using PHPUnit.

```php
public function testSomeTest(): void {
    $methodMock = new MockedMethod($this, SomeClass::class, 'someMethod', once());
    $methodMock->getMocker()->willReturn(10);

    SomeClass::someMethod(); // will return `10`
    
    SomeClass::someMethod(); // will cause error (expectation - one call)
}
```