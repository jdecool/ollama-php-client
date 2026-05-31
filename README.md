**DEPRECATED**

This package is deprecated. Please use [symfony/ai-ollama-platform](https://github.com/symfony/ai-ollama-platform) instead,
which is part of the official [Symfony AI Platform](https://github.com/symfony/ai-platform) component.

> [!IMPORTANT]
> This library is no longer maintained. Use Symfony AI components as replacement.

See the [Symfony AI Platform documentation](https://symfony.com/doc/current/ai/components/platform.html) for usage.

---

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
