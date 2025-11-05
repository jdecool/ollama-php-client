<?php declare(strict_types=1);

namespace JDecool\OllamaClient\Client;

class ToolCall extends Request
{
    public static function fromArray(array $data): self
    {
        return new self(
            function: ToolCallFunction::fromArray($data['function']),
        );
    }

    public function __construct(
        public readonly ToolCallFunction $function,
    ) {
    }

    public function toArray(): array
    {
        return [
            'function' => $this->function->toArray(),
        ];
    }
}
