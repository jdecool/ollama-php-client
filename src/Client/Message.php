<?php declare(strict_types=1);

namespace JDecool\OllamaClient\Client;

class Message extends Request
{
    public static function fromArray(array $data): self
    {
        $toolCalls = null;
        if (isset($data['tool_calls'])) {
            $toolCalls = array_map(
                fn (array $toolCall) => ToolCall::fromArray($toolCall),
                $data['tool_calls']
            );
        }

        return new self(
            role: $data['role'],
            content: $data['content'] ?? '',
            toolCalls: $toolCalls,
        );
    }

    /**
     * @param ToolCall[]|null $toolCalls
     */
    public function __construct(
        public readonly string $role,
        public readonly string $content,
        public readonly ?array $toolCalls = null,
        // public readonly array $images = [],
    ) {
    }

    public function toArray(): array
    {
        $data = [
            'role' => $this->role,
            'content' => $this->content,
        ];

        if ($this->toolCalls !== null) {
            $data['tool_calls'] = array_map(
                fn (ToolCall $toolCall) => $toolCall->toArray(),
                $this->toolCalls
            );
        }

        return $data;
    }
}
