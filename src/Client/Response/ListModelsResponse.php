<?php declare(strict_types=1);

namespace JDecool\OllamaClient\Client\Response;

use JDecool\OllamaClient\Resource\Model;

class ListModelsResponse
{
    public static function fromArray(array $data): self
    {
        return new self(
            array_map(Model::fromArray(...), $data['models']),
        );
    }

    /**
     * @param Model[] $models
     */
    public function __construct(
        public readonly array $models,
    ) {
    }
}
