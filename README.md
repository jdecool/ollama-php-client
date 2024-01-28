Ollama PHP Client
=================

This is a PHP client for the Ollama API.

## Getting Started

```
$ composer require jdecool/ollama-client
```

## Usage

```php
use JDecool\OllamaClient\ClientBuilder;

$builder = new ClientBuilder();
$client = $builder->create();
```
