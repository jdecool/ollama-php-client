<?php declare(strict_types=1);

namespace JDecool\OllamaClient\Client\Request;

use JDecool\OllamaClient\Client\Request;

class PullRequest extends Request
{
    public function __construct(
        public readonly string $name,
        public readonly bool $insecure = false,
    ) {
    }
}
