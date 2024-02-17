<?php declare(strict_types=1);

namespace JDecool\OllamaClient\Resource\Model;

class Details
{
    public static function fromArray(array $data): self
    {
        return new self(
            $data['format'],
            $data['family'],
            $data['families'],
            $data['parameter_size'],
            $data['quantization_level'],
        );
    }

    /**
     * @param string[] $families
     */
    public function __construct(
        public readonly string $format,
        public readonly string $family,
        public readonly array $families,
        public readonly string $parameterSize,
        public readonly string $quantizationLevel,
    ) {
    }
}
