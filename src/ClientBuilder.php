<?php declare(strict_types=1);

namespace JDecool\OllamaClient;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\ScopingHttpClient;

class ClientBuilder
{
    public function __construct(
        private readonly LoggerInterface $logger = new NullLogger(),
    ) {
    }

    public function create(string $endpoint = 'http://localhost:11434'): Client
    {
        $http = new Http(
            ScopingHttpClient::forBaseUri(HttpClient::create(), $endpoint),
            $this->logger,
        );

        return new Client($http);
    }
}
