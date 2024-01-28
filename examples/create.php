<?php declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use JDecool\OllamaClient\ClientBuilder;
use JDecool\OllamaClient\Model\Request\CreateRequest;

$builder = new ClientBuilder();

$client = $builder->create();

$modelFile = <<<MODEL
FROM tinyllama
SYSTEM "You are mario from super mario bros."
MODEL;

// stream
$request = new CreateRequest('foo', $modelFile);
foreach ($client->createStream($request) as $chunk) {
    var_dump($chunk);
}

// sync
$request = CreateRequest::fromFile('foo', __DIR__.'/Modelfile');
$client->create($request);
