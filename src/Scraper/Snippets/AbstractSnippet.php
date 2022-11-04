<?php

/*
 * This file is part of the recruitment exercise.
 *
 * @author Michal Kazmierczak <michal.kazmierczak@oldwestenterprises.pl>
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Scraper\Snippets;

/**
 * Parses a DOM node, looking for an element with given class, ID or attributes.
 *
 * Scraped value is accessible by value() method.
 */
abstract class AbstractSnippet
{
    protected $node;
    protected mixed $value;

    /**
     * Inits value
     */
    public function __construct()
    {
        $this->value = null;
    }

    /**
     * Wraps parse function in try/catch, because all the scraper needs to know is just a success or failure.
     *
     * @param mixed $node An instance of Symfony\Component\DomCrawler\Crawler or DOMElement.
     */
    public function scrape(mixed $node) : void
    {
        $this->value = null;
        try {
            $this->parse($node);
        } catch (\Exception $e) {
            if (defined("self::OPTION_REQUIRED")) {
                throw new \Exception(sprintf("Unable to scrape content for %s snippet.", $this::class));
            }
        }
    }

    /**
     * @return mixed A scrapped value.
     */
    public function value() : mixed
    {
        return $this->value;
    }

    /**
     * This is where actual scraping is taking place.
     *
     * The only method a derived class needs to implement.
     *
     * @param mixed $node An instance of Symfony\Component\DomCrawler\Crawler or DOMElement.
     */
    abstract protected function parse(mixed $node) : void;
}
