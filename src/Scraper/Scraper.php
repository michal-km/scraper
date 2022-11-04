<?php

/*
 * This file is part of the recruitment exercise.
 *
 * @author Michal Kazmierczak <michal.kazmierczak@oldwestenterprises.pl>
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Scraper;

use Symfony\Component\DomCrawler\Crawler;
use App\Scraper\Option;

/**
 * A HTML scraper
 */
class Scraper
{
    private Crawler $crawler;
    private OptionScraper $optionScraper;

    /**
     * For the purpose of testing, a TestCrawler is injected (@see config/services.yml) which works on pre-saved html file.
     * In real life case, abusing scraped website during test sessions could end with a ban / blocked IP.
     *
     * @param Crawler        $crawler       Auto-injected crawler object.
     * @param OptionScrapper $optionScraper Auto-injected OptionScraper object.
     */
    public function __construct(Crawler $crawler, OptionScraper $optionScraper)
    {
        $this->crawler = $crawler;
        $this->optionScraper = $optionScraper;
    }

    /**
     * The main scraping loop
     *
     * @return array All the options (packages) found on the page, sorted by yearly price (DESC).
     */
    public function scrape() : array
    {
        $this->options = [];
        $this->crawler->load();
        $this->crawler->filter('.package')->each(function ($node) {
            $this->optionScraper->scrape($node);
            $this->options[$this->optionScraper->getProperty("price")] = $this->optionScraper->getProperties();
        });
        krsort($this->options);

        return $this->options;
    }
}
