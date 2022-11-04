<?php declare(strict_types=1);

/*
 * This file is part of the recruitment exercise.
 *
 * @author Michal Kazmierczak <michal.kazmierczak@oldwestenterprises.pl>
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace Tests\Crawler;

use PHPUnit\Framework\TestCase;
use App\Crawler\TestCrawler;

/**
 * TestCrawler unit test.
 */
final class TestCrawlerTest extends TestCase
{
    /**
     * All crawlers should be descendants of \Symfony\Component\DomCrawler\Crawler.
     */
    public function testConstructor() : void
    {
        $crawler = new TestCrawler();
        $this->assertInstanceOf("\Symfony\Component\DomCrawler\Crawler", $crawler);
    }

    /**
     * Load function must result with a DOM ready to parse. Test crawler uses presaved HTML file to avoid abusing the real server.
     */
    public function testLoad() : void
    {
        $crawler = new TestCrawler();
        $crawler->load();
        $text = $crawler->filter(".package")->text();
        $this->assertSame((strlen($text) > 0), true);
    }
}
