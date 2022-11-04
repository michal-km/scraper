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
use Symfony\Component\DomCrawler\Crawler;
use Goutte\Client;
use Campo\UserAgent;

/**
 * This crawler should be used for scraping from the live website.
 */
class RemoteCrawler extends Crawler
{
    private HttpClientInterface $httpClient;

    /**
     * In real scraping, $httpClient should closely imitate true web browser with headers information, cookies jar and js support.
     * Even better, a proxy service should provide different IPs for every request.
     * Here is a very basic simulation performed: a random User Agent is generated for every request.
     *
     * @param HttpClient $httpClient Injected Symfony HttpClient component.
     */
    public function __construct()
    {
        $options = [
            'timeout' => 60,
            'headers' => [
                'User-Agent' =>  UserAgent::random(),
                'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
                'Referer' => 'http://google.com',
            ]
        ];
        $this->client = new Client(HttpClient::create($options));
        parent::__construct();
    }

    /**
     * Clears existing DOM data and loads a new document.
     *
     * @param ?string $url An URL to load content from. If null, a dummy document is created.
     */
    public function load(?string $url = null) : void
    {
        $this->clear();
        if (null !== $url) {
            $html = $this->client->request('GET', $url);
        } else {
            $html = "<html><head><title>Empty document</title></head><body><div class=\"info\">Empty document</div></body></html>";
        }
        $this->add($html);
    }
}
