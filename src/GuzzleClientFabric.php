<?php declare(strict_types=1);

namespace rubin\adapter\guzzle;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlMultiHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\MessageFormatter;
use GuzzleHttp\Middleware;
use Psr\Log\LoggerInterface;

final class GuzzleClientFabric implements GuzzleClientFabricInterface
{
    public function build(string $base, LoggerInterface $logger): Client
    {
        $stack = HandlerStack::create();
        $stack->push(Middleware::prepareBody(), 'body');
        $stack->push(
            Middleware::log(
                $logger,
                new MessageFormatter(MessageFormatter::CLF)
            )
        );
        $stack->push(
            Middleware::log(
                $logger,
                new MessageFormatter(MessageFormatter::DEBUG)
            )
        );
        $stack->setHandler(new CurlMultiHandler());

        return new Client([
            'base_uri' => $base,
            'handler' => $stack,
            'http_errors' => false
        ]);
    }
}
