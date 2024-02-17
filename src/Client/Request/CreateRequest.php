<?php declare(strict_types=1);

namespace JDecool\OllamaClient\Client\Request;

use InvalidArgumentException;
use JDecool\OllamaClient\Client\Request;

class CreateRequest extends Request
{
    public static function fromFile(string $name, string $path): self
    {
        if (!file_exists($path)) {
            throw new InvalidArgumentException("File \"%s\" does not exist.");
        }

        if (!is_readable($path)) {
            throw new InvalidArgumentException("File \"%s\" is not readable.");
        }

        $content = file_get_contents($path);
        if ($content === false) {
            throw new InvalidArgumentException("Error while reading file \"%s\".");
        }

        return new self($name, $content);
    }

    public function __construct(
        public readonly string $name,
        public readonly string $modelFile,
    ) {
    }
}
