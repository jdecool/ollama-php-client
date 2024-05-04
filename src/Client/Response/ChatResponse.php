<?php declare(strict_types=1);

namespace JDecool\OllamaClient\Client\Response;

use DateTimeImmutable;
use JDecool\OllamaClient\Client\Message;

class ChatResponse
{
    public static function fromArray(array $data): self
    {
        return new self(
            model: $data['model'],
            createdAt: new DateTimeImmutable($data['created_at']),
            message: Message::fromArray($data['message']),
            done: $data['done'],
            totalDuration: $data['total_duration'] ?? null,
            loadDuration: $data['load_duration'] ?? null,
            promptEvalCount: $data['prompt_eval_count'] ?? null,
            promptEvalDuration: $data['prompt_eval_duration'] ?? null,
            evalCount: $data['eval_count'] ?? null,
        );
    }

    public function __construct(
        public readonly string $model,
        public readonly DateTimeImmutable $createdAt,
        public readonly Message $message,
        public readonly bool $done,
        public readonly ?int $totalDuration,
        public readonly ?int $loadDuration,
        public readonly ?int $promptEvalCount,
        public readonly ?int $promptEvalDuration,
        public readonly ?int $evalCount,
    ) {
    }
}
