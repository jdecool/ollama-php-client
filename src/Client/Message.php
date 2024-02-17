<?php declare(strict_types=1);

namespace JDecool\OllamaClient\Client;

class Message extends Request
{
    public static function fromArray(array $data): self
    {
        return new self($data['role'], $data['content'], /* $data['images'] */);
    }

    public function __construct(
        public readonly string $role,
        public readonly string $content,
        // public readonly array $images = [],
    ) {
    }
}
