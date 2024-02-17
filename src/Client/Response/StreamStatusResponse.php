<?php declare(strict_types=1);

namespace JDecool\OllamaClient\Client\Response;

class StreamStatusResponse
{
    public static function fromArray(array $data): self
    {
        return new self(
            status: $data['status'],
        );
    }

    public function __construct(
        public readonly string $status,
    ) {
    }
}
