<?php declare(strict_types=1);

namespace JDecool\OllamaClient\Client;

class ToolCallFunction extends Request
{
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            arguments: $data['arguments'],
        );
    }

    public function __construct(
        public readonly string $name,
        public readonly array $arguments,
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'arguments' => $this->arguments,
        ];
    }
}
