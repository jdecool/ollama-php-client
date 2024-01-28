<?php declare(strict_types=1);

namespace JDecool\OllamaClient;

use Exception;
use Throwable;

class OllamaException extends Exception
{
    public function __construct(public readonly array $response, string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
