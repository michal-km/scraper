<?php

declare(strict_types=1);

/*
 * This file is part of the recruitment exercise.
 *
 * @author Michal Kazmierczak <michal.kazmierczak@oldwestenterprises.pl>
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Scraper;

/**
 * Scrapes and stores scraped data for a single Option.
 */
class OptionScraper
{
    private array $snippets;

    /**
     * Automatic snippet discovery.
     *
     * All AbstractSnippet descendant classes located in \App\Scraper\Snippets\ are automatically discovered
     * and injected to the constructor. To scrape another piece of content all you need is to create another
     * snippet with its own name.
     *
     * @param iterable $snippets An injected list of snippet objects.
     */
    public function __construct(iterable $snippets = [])
    {
        foreach ($snippets as $s) {
            $this->snippets[] = $s;
        }
    }

    /**
     * All the registered scraping snippets are run on a given piece of content.
     *
     * @param mixed $node An instance of Symfony\Component\DomCrawler\Crawler or DOMElement.
     */
    public function scrape($node): void
    {
        foreach ($this->snippets as $snippet) {
            $snippet->scrape($node);
        }
    }

    /**
     * Search all registered snippets for a given name.
     *
     * @param string $name A snippet's name.
     *
     * @return mixed If found, a scraped value is returned.
     * If the scrape process failed or if the snippet could not be found, the method returns null.
     */
    public function getProperty(string $name): mixed
    {
        $value = null;
        foreach ($this->snippets as $snippet) {
            if ($name === $snippet::OPTION_NAME) {
                $value = $snippet->value();
            }
        }

        return $value;
    }

    /**
     * Returns all the scraped data.
     *
     * @return array All scraped values in form of an associative array with snippet names as the keys.
     */
    public function getProperties(): array
    {
        $properties = [];
        foreach ($this->snippets as $snippet) {
            $properties[$snippet::OPTION_NAME] = $snippet->value();
        }

        return $properties;
    }
}
