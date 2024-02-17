<?php declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

use JDecool\OllamaClient\ClientBuilder;
use JDecool\OllamaClient\Model\Request\CreateRequest;

$builder = new ClientBuilder();

$client = $builder->create();

var_dump($client->list());
