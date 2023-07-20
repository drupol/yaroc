<?php

declare(strict_types=1);

namespace drupol\Yaroc;

use Throwable;

final class Exception extends \Exception
{
    public static function invalidRequest(Throwable $previous): self
    {
        return new self(
            'Invalid request.',
            (int) $previous->getCode(),
            $previous
        );
    }

    public static function invalidStatusCode(int $statusCode): self
    {
        return new self(sprintf('Invalid status code: %d', $statusCode));
    }

    public static function jsonRpcError(int $code): self
    {
        $error = Errors::fromCode($code);

        return new self(sprintf('JSON-RPC error: %s, %s', $error->message(), $error->meaning()), $code);
    }

    public static function unableToDecodeJson(Throwable $previous): self
    {
        return new self('Unable to decode JSON', 0, $previous);
    }

    public static function unableToExtractResult(): self
    {
        return new self('Unable to extract result.');
    }

    public static function unableToSendRequest(Throwable $previous): self
    {
        return new self(
            sprintf('Unable to send request: %s', $previous->getMessage()),
            (int) $previous->getCode(),
            $previous
        );
    }
}
