<?php

/*
 * This file is part of the recruitment exercise.
 *
 * @author Michal Kazmierczak <michal.kazmierczak@oldwestenterprises.pl>
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Crawler;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\DomCrawler\Crawler as Dom;
use Goutte\Client;
use Campo\UserAgent;
use App\Crawler\CrawlerInterface;

/**
 * This crawler should be used for scraping from the live website.
 */
class RemoteCrawler implements CrawlerInterface
{
    private HttpClientInterface $httpClient;
    private Client $client;
    private ?Dom $dom;

    /**
     * In real scraping, $httpClient should closely imitate true web browser with headers information, cookies jar and js support.
     * Even better, a proxy service should provide different IPs for every request.
     * Here is a very basic simulation performed: a random User Agent is generated for every request.
     */
    public function __construct()
    {
        $options = [
            'timeout' => 60,
            'headers' => [
                'User-Agent' =>  UserAgent::random(),
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                'Referer' => 'http://google.com',
            ],
        ];
        $this->client = new Client(HttpClient::create($options));
        $this->dom = null;
    }

    /**
     * Clears existing DOM data and loads a new document.
     *
     * @param ?string $uri An URL to load content from. If null, a dummy document is created.
     */
    public function load(?string $uri = null) : void
    {
        $this->dom = null;
        if (null !== $uri) {
            $this->dom = $this->client->request('GET', $uri);
        } else {
            $html = "<html><head><title>Empty document</title></head><body><div class=\"info\">Empty document</div></body></html>";
            $this->dom = new Dom($html);
        }
    }

    /**
     * @return ?Crawler An initialized DOM crawler or null if the document was not loaded.
     */
    public function dom() : ?Dom
    {
        return $this->dom;
    }
}
