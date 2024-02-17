<?php declare(strict_types=1);

namespace JDecool\OllamaClient\Client;

abstract class Request implements \JsonSerializable
{
    public const FORMAT_JSON = 'json';

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
