<?php declare(strict_types=1);

namespace JDecool\OllamaClient\Client;

class ToolFunction extends Request
{
    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            description: $data['description'],
            parameters: $data['parameters'],
        );
    }

    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly array $parameters,
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'parameters' => $this->parameters,
        ];
    }
}
