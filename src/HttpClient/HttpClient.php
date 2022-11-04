<?php

namespace App\HttpClient;

use Symfony\Component\HttpClient\HttpClient as SymfonyHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * A decorator for Symfony HttpClient, providing some emulation of a real web browser.
 */
class HttpClient
{
    public static function create(array $defaultOptions = [], int $maxHostConnections = 6, int $maxPendingPushes = 50): HttpClientInterface
    {
        return SymfonyHttpClient::create($defaultOptions, $maxHostConnections, $maxHostConnections);
    }
}