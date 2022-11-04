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

/**
 * This crawler should be used for scraping from the live website.
 */
class RemoteCrawler extends Crawler
{
    private HttpClientInterface $httpClient;

    /**
     * In real life case, $httpClient should closely imitate true web browser with headers information.
     * Even better, a proxy service should provide different IPs for every request.
     * Here, a very basic simulation is performed.
     *
     * @param HttpClient $httpClient Injected Symfony HttpClient component.
     */
    public function __construct()
    {
        $this->client = new Client(HttpClient::create(['timeout' => 60]));
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
