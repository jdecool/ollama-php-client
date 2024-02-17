<?php declare(strict_types=1);

namespace JDecool\OllamaClient\Client\Response;

use DateTimeImmutable;
use JDecool\OllamaClient\Client\Message;

class ChatStreamResponse
{
    public static function fromArray(array $data): self
    {
        return new self(
            model: $data['model'],
            createdAt: new DateTimeImmutable($data['created_at']),
            message: Message::fromArray($data['message']),
            done: $data['done'],
        );
    }

    public function __construct(
        public readonly string $model,
        public readonly DateTimeImmutable $createdAt,
        public readonly Message $message,
        public readonly bool $done,
    ) {
    }
}
