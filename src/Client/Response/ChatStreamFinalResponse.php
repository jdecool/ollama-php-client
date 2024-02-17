<?php declare(strict_types=1);

namespace JDecool\OllamaClient\Client\Response;

use DateTimeImmutable;
use JDecool\OllamaClient\Client\Message;

class ChatStreamFinalResponse extends ChatStreamResponse
{
    public static function fromArray(array $data): self
    {
        return new self(
            model: $data['model'],
            createdAt: new DateTimeImmutable($data['created_at']),
            message: Message::fromArray($data['message']),
            done: $data['done'],
            totalDuration: $data['total_duration'],
            loadDuration: $data['load_duration'],
            promptEvalCount: $data['prompt_eval_count'],
            promptEvalDuration: $data['prompt_eval_duration'],
            evalCount: $data['eval_count'],
        );
    }

    public function __construct(
        string $model,
        DateTimeImmutable $createdAt,
        Message $message,
        bool $done,
        public readonly int $totalDuration,
        public readonly int $loadDuration,
        public readonly int $promptEvalCount,
        public readonly int $promptEvalDuration,
        public readonly int $evalCount,
    ) {
        parent::__construct($model, $createdAt, $message, $done);
    }
}
