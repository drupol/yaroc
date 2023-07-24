<?php

declare(strict_types=1);

namespace drupol\Yaroc;

use Psr\Http\Message\ResponseInterface;

/**
 * @psalm-type JsonRpcReturnType = array{id: string, jsonrpc: string, error?: array{code: int, message: string, data?: mixed}, method: string, params?: array<string, mixed>, result?: array{random?: array{data?: array<mixed>}}}
 */
interface ClientInterface
{
    /**
     * @throws Exception
     */
    public function call(ApiMethods $method, array $parameters = [], array $body = []): ResponseInterface;

    /**
     * @throws Exception
     *
     * @return JsonRpcReturnType
     */
    public function get(ApiMethods $method, array $parameters = []): array;

    /**
     * @throws Exception
     *
     * @return array<mixed>
     */
    public function getData(ApiMethods $method, array $parameters = []): array;
}
