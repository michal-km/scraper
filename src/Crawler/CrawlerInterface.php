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

interface CrawlerInterface
{
    public function load(?string $url = null) : void;

    /**
     * @return ?Crawler An initialized DOM crawler or null if the document was not loaded.
     */
    public function dom() : ?Crawler;
}
