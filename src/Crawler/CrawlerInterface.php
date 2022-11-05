<?php

declare(strict_types=1);

/*
 * This file is part of the recruitment exercise.
 *
 * @author Michal Kazmierczak <michal.kazmierczak@oldwestenterprises.pl>
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Crawler;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Common interface for test and remote (production) crawlers.
 */
interface CrawlerInterface
{
    /**
     * @param ?string $uri A location of a source document to load. If not given, a default test file is used.
     */
    public function load(?string $uri = null): void;

    /**
     * @return ?Crawler An initialized DOM crawler or null if the document was not loaded.
     */
    public function dom(): ?Crawler;
}
