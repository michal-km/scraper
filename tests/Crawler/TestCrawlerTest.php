<?php

declare(strict_types=1);

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
     * All crawlers have dom() returning an instance of \Symfony\Component\DomCrawler\Crawler or a null value.
     */
    public function testConstructor(): void
    {
        $crawler = new TestCrawler();
        $this->assertSame(null, $crawler->dom());
    }

    /**
     * Load function must generate a DOM object. Test crawler uses presaved HTML file to avoid abusing the real server.
     */
    public function testLoad(): void
    {
        $crawler = new TestCrawler();
        $crawler->load();
        $this->assertInstanceOf("\Symfony\Component\DomCrawler\Crawler", $crawler->dom());
        $text = $crawler->dom()->filter(".package")->text();
        $this->assertSame((strlen($text) > 0), true);
    }
}
