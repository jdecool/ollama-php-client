<?php declare(strict_types=1);

namespace JDecool\OllamaClient;

use Generator;
use JDecool\OllamaClient\Client\Request;
use JDecool\OllamaClient\Client\Response;
use JsonException;
use function json_encode;

class Client
{
    public function __construct(
        private readonly Http $http,
    ) {
    }

    /**
     * @throws OllamaException
     */
    public function chat(Request\ChatRequest $request): Response\ChatResponse
    {
        $data = $this->processRequest('POST', 'chat', $request);

        return Response\ChatResponse::fromArray($data);
    }

    /**
     * @return Generator<Response\ChatStreamResponse|Response\ChatStreamFinalResponse>
     *
     * @throws OllamaException
     */
    public function chatStream(Request\ChatRequest $request): Generator
    {
        foreach ($this->processStream('POST', 'chat', $request) as $chunk) {
            /** @phpstan-ignore-next-line */
            yield match ($chunk['done'] ?? false) {
                true => Response\ChatStreamFinalResponse::fromArray($chunk),
                false => Response\ChatStreamResponse::fromArray($chunk),
            };
        }
    }

    /**
     * @throws OllamaException
     */
    public function create(Request\CreateRequest $request): void
    {
        $data = $this->processRequest('POST', 'create', $request);

        $this->processResponseWithoutContent($data);
    }

    /**
     * @return Generator<Response\StreamStatusResponse>
     *
     * @throws OllamaException
     */
    public function createStream(Request\CreateRequest $request): Generator
    {
        foreach ($this->processStream('POST', 'create', $request) as $chunk) {
            yield Response\StreamStatusResponse::fromArray($chunk);
        }
    }

    public function list(): Response\ListModelsResponse
    {
        $data = $this->processRequest('GET', 'tags');

        return Response\ListModelsResponse::fromArray($data);
    }

    /**
     * @throws OllamaException
     */
    public function pull(Request\PullRequest $request): void
    {
        $data = $this->processRequest('POST', 'pull', $request);

        $this->processResponseWithoutContent($data);
    }

    /**
     * @return Generator<Response\StreamStatusResponse>
     *
     * @throws OllamaException
     */
    public function pullStream(Request\PullRequest $request): Generator
    {
        foreach ($this->processStream('POST', 'pull', $request) as $chunk) {
            yield Response\StreamStatusResponse::fromArray($chunk);
        }
    }

    /**
     * @throws OllamaException
     */
    public function push(Request\PushRequest $request): void
    {
        $data = $this->processRequest('POST', 'push', $request);

        $this->processResponseWithoutContent($data);
    }

    /**
     * @return Generator<Response\StreamStatusResponse>
     *
     * @throws OllamaException
     */
    public function pushStream(Request\PushRequest $request): Generator
    {
        foreach ($this->processStream('POST', 'push', $request) as $chunk) {
            yield Response\StreamStatusResponse::fromArray($chunk);
        }
    }

    /**
     * @throws OllamaException
     */
    private function processRequest(string $method, string $endpoint, ?Client\Request $request = null): array
    {
        $body = $request?->toArray();
        if ($body !== null) {
            $body['stream'] = false;

            $body = json_encode($body, JSON_THROW_ON_ERROR);
        }

        $response = $this->http->request($method, "/api/$endpoint", body: $body);

        try {
            $data = json_decode($response, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new OllamaException([], 'Invalid JSON.', previous: $e);
        }

        if (!is_array($data)) {
            throw new OllamaException([], 'Invalid response content.');
        }

        return $data;
    }

    /**
     * @return Generator<array>
     */
    private function processStream(string $method, string $endpoint, Client\Request $request): Generator
    {
        $body = $request->toArray();
        $body['stream'] = true;

        $chunks = $this->http->stream($method, "/api/$endpoint", body: json_encode($body, JSON_THROW_ON_ERROR));
        foreach ($chunks as $chunk) {
            try {
                $content = json_decode($chunk, true, flags: JSON_THROW_ON_ERROR);
            } catch (JsonException $e) {
                throw new OllamaException([], 'Invalid JSON.', previous: $e);
            }

            if (!is_array($content)) {
                throw new OllamaException([], 'Invalid response content.');
            }

            yield $content;
        }
    }

    /**
     * @throws OllamaException
     */
    private function processResponseWithoutContent(array $data): void
    {
        if (isset($data['error'])) {
            throw new OllamaException($data, $data['error']);
        }

        if ($data['status'] !== 'success') {
            throw new OllamaException($data, 'Unexpected response.');
        }
    }
}
