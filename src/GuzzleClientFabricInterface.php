<?php declare(strict_types=1);

namespace rubin\adapter\guzzle;

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

interface GuzzleClientFabricInterface
{
    public function build(string $base, LoggerInterface $logger): Client;
}
