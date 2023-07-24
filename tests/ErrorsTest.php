<?php

declare(strict_types=1);

namespace drupol\Yaroc\Tests;

use drupol\Yaroc\Errors;
use PHPUnit\Framework\TestCase;

/**
 * @covers \drupol\Yaroc\Errors
 *
 * @internal
 */
final class ErrorsTest extends TestCase
{
    public static function provideMeaningCases(): iterable
    {
        yield ['errorCode' => -32700, 'errorName' => 'ParseError', 'errorMeaning' => 'Invalid JSON was received by the server. An error occurred on the server while parsing the JSON text.'];

        yield ['errorCode' => -32600, 'errorName' => 'InvalidRequest', 'errorMeaning' => 'The JSON sent is not a valid Request object.'];

        yield ['errorCode' => -32601, 'errorName' => 'MethodNotFound', 'errorMeaning' => 'The method does not exist / is not available.'];

        yield ['errorCode' => -32602, 'errorName' => 'InvalidParams', 'errorMeaning' => 'Invalid method parameter(s).'];

        yield ['errorCode' => -32603, 'errorName' => 'InternalError', 'errorMeaning' => 'Internal JSON-RPC error.'];

        yield ['errorCode' => 123, 'errorName' => 'ServerError', 'errorMeaning' => 'Server error.'];
    }

    /**
     * @dataProvider provideMeaningCases
     */
    public function testMeaning(int $errorCode, string $errorName, string $errorMeaning)
    {
        self::assertEquals(Errors::fromCode($errorCode)->name, $errorName);
        self::assertEquals(Errors::fromCode($errorCode)->meaning(), $errorMeaning);
    }
}
