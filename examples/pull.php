<?php declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use JDecool\OllamaClient\ClientBuilder;
use JDecool\OllamaClient\Model\Request\PullRequest;

$builder = new ClientBuilder();

$client = $builder->create();

$request = new PullRequest('tinyllama');

// sync
$client->pullStream($request);

// stream
foreach ($client->pullStream($request) as $chunk) {
    var_dump($chunk);
}
