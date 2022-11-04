<?php

/*
 * This file is part of the recruitment exercise.
 *
 * @author Michal Kazmierczak <michal.kazmierczak@oldwestenterprises.pl>
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Crawler;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpClient\HttpClient;
use Goutte\Client;

/**
 * This crawler should be used for scraping from the live website.
 */
class RemoteCrawler extends Crawler
{
    /**
     * Clears existing DOM data and loads a new document.
     *
     * In real life case, $httpClient should closely imitate true web browser with headers information.
     * If it is not provided (nulled), a dummy document is generated.
     *
     * @param HttpClient $httpClient A HttpClient implementing PSR-18 interface.
     */
    public function load(?HttpClient $httpClient) : void
    {
        $this->clear();
        if (null !== $httpClient) {
            $client = new Client($this->httpClient);
            $html = $client->request('GET', 'https://www.symfony.com/blog/');
        } else {
            $html = "<html><head><title>Empty document</title></head><body><div class=\"info\">Empty document</div></body></html>";
        }
        $this->add($html);
    }
}
