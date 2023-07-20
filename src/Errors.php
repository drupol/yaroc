<?php

declare(strict_types=1);

namespace drupol\Yaroc;

enum Errors
{
    public static function fromCode(int $code): self
    {
        return match ($code) {
            -32700 => self::ParseError,
            -32600 => self::InvalidRequest,
            -32601 => self::MethodNotFound,
            -32602 => self::InvalidParams,
            -32603 => self::InternalError,
            default => self::ServerError,
        };
    }

    public function meaning(): string
    {
        return match ($this) {
            self::ParseError => 'Invalid JSON was received by the server. An error occurred on the server while parsing the JSON text.',
            self::InvalidRequest => 'The JSON sent is not a valid Request object.',
            self::MethodNotFound => 'The method does not exist / is not available.',
            self::InvalidParams => 'Invalid method parameter(s).',
            self::InternalError => 'Internal JSON-RPC error.',
            self::ServerError => 'Server error.',
        };
    }

    public function message(): string
    {
        return match ($this) {
            self::ParseError => 'Parse error',
            self::InvalidRequest => 'Invalid request',
            self::MethodNotFound => 'Method not found',
            self::InvalidParams => 'Invalid params',
            self::InternalError => 'Internal error',
            self::ServerError => 'Server error',
        };
    }

    case InternalError;

    case InvalidParams;

    case InvalidRequest;

    case MethodNotFound;

    case ParseError;

    case ServerError;
}
