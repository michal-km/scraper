<?php

declare(strict_types=1);

/*
 * This file is part of the recruitment exercise.
 *
 * @author Michal Kazmierczak <michal.kazmierczak@oldwestenterprises.pl>
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace Tests\Scraper;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use App\Crawler\TestCrawler;
use App\Scraper\Scraper;
use App\Scraper\OptionScraper;
use App\Scraper\Snippets\NameSnippet;

/**
 * {@inheritDoc}
 */
final class ScraperTest extends TestCase
{
    private Scraper $scraper;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        $container = new ContainerBuilder();
        $loader = new YamlFileLoader($container, new FileLocator());
        $loader->load(__DIR__ . '/../../config/services.test.yml');
        $container->compile();
        $optionScraper = $container->get(\App\Scraper\OptionScraper::class);

        $crawler = new TestCrawler();
        $crawler->load();
        $this->scraper = new Scraper($crawler, $optionScraper);
    }

    /**
     * {@inheritDoc}
     */
    public function testScrape(): void
    {
        $data = $this->scraper->scrape(null);
        $this->assertIsArray($data);
        $this->assertNotEmpty($data);
        foreach ($data as $d) {
            $this->assertIsArray($d);
            $this->assertNotEmpty($d);
        }
    }
}
