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
use App\Crawler\RemoteCrawler;

/**
 * RemoteCrawler unit test.
 */
final class RemoteCrawlerTest extends TestCase
{
    /**
     * All crawlers should be descendants of \Symfony\Component\DomCrawler\Crawler.
     */
    public function testConstructor() : void
    {
        $crawler = new RemoteCrawler();
        $this->assertInstanceOf("\Symfony\Component\DomCrawler\Crawler", $crawler);
    }

    /**
     * RemoteCrawler fetches data from a real website and it is not desirable to do it in every testing session.
     * Therefore. load function test is simplified.
     */
    public function testLoad() : void
    {
        $crawler = new RemoteCrawler();
        $crawler->load(null);
        $text = $crawler->filter(".info")->text();
        $this->assertSame("Empty document", $text);
    }
}
