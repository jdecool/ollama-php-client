<?php declare(strict_types=1);

namespace JDecool\OllamaClient\Client;

class Tool extends Request
{
    public const TYPE_FUNCTION = 'function';

    public static function fromArray(array $data): self
    {
        return new self(
            type: $data['type'],
            function: ToolFunction::fromArray($data['function']),
        );
    }

    public function __construct(
        public readonly string $type,
        public readonly ToolFunction $function,
    ) {
    }

    public function toArray(): array
    {
        return [
            'type' => $this->type,
            'function' => $this->function->toArray(),
        ];
    }
}
