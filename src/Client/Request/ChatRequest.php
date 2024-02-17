<?php declare(strict_types=1);

namespace JDecool\OllamaClient\Client\Request;

use JDecool\OllamaClient\Client\Request;

class ChatRequest extends Request
{
    public static function fromArray(array $data): self
    {
        return new self(
            model: $data['model'],
            messages: $data['messages'] ?? [],
            format: $data['format'] ?? self::FORMAT_JSON,
        );
    }

    public function __construct(
        public readonly string $model,
        public readonly array $messages = [],
        public readonly string $format = self::FORMAT_JSON,
    ) {
    }
}
