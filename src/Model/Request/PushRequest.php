<?php declare(strict_types=1);

namespace JDecool\OllamaClient\Model\Request;

use JDecool\OllamaClient\Model\Request;

class PushRequest extends Request
{
    public function __construct(
        public readonly string $name,
        public readonly bool $insecure = false,
    ) {
    }
}
