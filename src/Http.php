<?php declare(strict_types=1);

namespace JDecool\OllamaClient;

use Generator;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class Http
{
    public function __construct(
        private readonly HttpClientInterface $http,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function request(string $method, string $uri, string $body = null): string
    {
        $response = $this->executeRequest($method, $uri, $body);

        $this->logger->debug('HTTP Response: {statusCode} {content}', [
            'statusCode' => $response->getStatusCode(),
            'content' => $response->getContent(),
        ]);

        return $response->getContent();
    }

    /**
     * @return Generator<string>
     */
    public function stream(string $method, string $uri, string $body = null): Generator
    {
        $response = $this->executeRequest($method, $uri, $body);

        foreach ($this->http->stream($response) as $chunk) {
            $content = $chunk->getContent();

            $this->logger->debug('HTTP Response chunk: {content}', [
                'content' => $content,
            ]);

            if (empty($content)) {
                continue;
            }

            yield $content;
        }
    }

    private function executeRequest(string $method, string $uri, string $body = null): ResponseInterface
    {
        $this->logger->debug('HTTP Request: {method} {uri}', [
            'method' => $method,
            'uri' => $uri,
            'body' => $body,
        ]);

        return $this->http->request($method, $uri, [
            'body' => $body,
        ]);
    }
}
