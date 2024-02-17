<?php declare(strict_types=1);

namespace JDecool\OllamaClient\Resource;

use DateTimeImmutable;
use JDecool\OllamaClient\Resource\Model\Details;

class Model
{
    public static function fromArray(array $data): self
    {
        return new self(
            $data['name'],
            new DateTimeImmutable($data['modified_at']),
            $data['size'],
            $data['digest'],
            Details::fromArray($data['details']),
        );
    }

    public function __construct(
        public readonly string            $name,
        public readonly DateTimeImmutable $modifiedAt,
        public readonly int               $size,
        public readonly string            $digest,
        public readonly Details           $details,
    ) {
    }
}
