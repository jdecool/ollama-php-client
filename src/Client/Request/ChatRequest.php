<?php declare(strict_types=1);

namespace JDecool\OllamaClient\Client\Request;

use JDecool\OllamaClient\Client\Request;
use JDecool\OllamaClient\Client\Tool;

class ChatRequest extends Request
{
    public static function fromArray(array $data): self
    {
        return new self(
            model: $data['model'],
            messages: $data['messages'] ?? [],
            tools: isset($data['tools']) ? array_map(Tool::fromArray(...), $data['tools']) : null,
            format: $data['format'] ?? null,
        );
    }

    /**
     * @param Tool[]|null $tools
     */
    public function __construct(
        public readonly string $model,
        public readonly array $messages = [],
        public readonly ?array $tools = null,
        public readonly ?string $format = null,
    ) {
    }

    public function toArray(): array
    {
        $data = [
            'model' => $this->model,
            'messages' => $this->messages,
        ];

        if ($this->tools !== null) {
            $data['tools'] = array_map(
                static fn (Tool $tool) => $tool->toArray(),
                $this->tools
            );
        }

        if ($this->format !== null) {
            $data['format'] = $this->format;
        }

        return $data;
    }
}
