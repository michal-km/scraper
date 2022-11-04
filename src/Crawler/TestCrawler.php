<?php

/*
 * This file is part of the recruitment exercise.
 *
 * @author Michal Kazmierczak <michal.kazmierczak@oldwestenterprises.pl>
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Crawler;

use Symfony\Component\DomCrawler\Crawler as Crawler;

/**
 * Crawler used in testing procedures.
 *
 * Runs on dummy data stored as a file in order to avoid abusing the live server.
 */
class TestCrawler extends Crawler
{
    /**
     * @param ?string $uri A location of a HTML file to load. If not given, a default test file is used.
     */
    public function load(?string $uri = null) : void
    {
        $this->clear();
        if (null === $uri) {
            $uri = __DIR__."/../../tests/Resources/page.html";
        }
        $html = file_get_contents($uri);
        $this->add($html);
    }
}
