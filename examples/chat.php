<?php declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use JDecool\OllamaClient\ClientBuilder;
use JDecool\OllamaClient\Client\Message;
use JDecool\OllamaClient\Client\Request\ChatRequest;

$builder = new ClientBuilder();
$client = $builder->create();

$request = new ChatRequest('tinyllama', [
    new Message('user', 'Why is the sky blue?'),
]);

// sync
var_dump($client->chat($request));

// async
foreach ($client->chatStream($request) as $chunk) {
    var_dump($chunk);
}
