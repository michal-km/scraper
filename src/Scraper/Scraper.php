<?php

/*
 * This file is part of the recruitment exercise.
 *
 * @author Michal Kazmierczak <michal.kazmierczak@oldwestenterprises.pl>
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Scraper;

use App\Crawler\CrawlerInterface;
use App\Scraper\Option;

/**
 * A HTML scraper
 */
class Scraper
{
    private CrawlerInterface $crawler;
    private OptionScraper $optionScraper;

    /**
     * For the purpose of testing, a TestCrawler is injected (@see config/services.yml) which works on pre-saved html file.
     * In real life case, abusing scraped website during test sessions could end with a ban / blocked IP.
     *
     * @param CrawlerInterface $crawler       Auto-injected crawler object.
     * @param OptionScrapper   $optionScraper Auto-injected OptionScraper object.
     */
    public function __construct(CrawlerInterface $crawler, OptionScraper $optionScraper)
    {
        $this->crawler = $crawler;
        $this->optionScraper = $optionScraper;
    }

    /**
     * The main scraping loop
     *
     * @param string $url URL of the website to scrape from. If null, the crawler should provide a default one or a dummy document.
     *
     * @return array All the options (packages) found on the page, sorted by yearly price (DESC).
     */
    public function scrape(?string $url) : array
    {
        $this->options = [];
        $this->crawler->load($url);
        $this->crawler->dom()->filter('.package')->each(function ($node) {
            $this->optionScraper->scrape($node);
            $this->options[$this->optionScraper->getProperty("price")] = $this->optionScraper->getProperties();
        });
        krsort($this->options);

        return $this->options;
    }
}
