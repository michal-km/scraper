<?php declare(strict_types=1);

/*
 * This file is part of the recruitment exercise.
 *
 * @author Michal Kazmierczak <michal.kazmierczak@oldwestenterprises.pl>
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace Tests\Scraper\Snippets;

use PHPUnit\Framework\TestCase;
use App\Crawler\TestCrawler;
use App\Scraper\Snippets\AbstractSnippet;

// phpcs:disable
class TestSnippet extends AbstractSnippet
{
    public const OPTION_NAME = "description";

    protected function parse($node) : void
    {
        $this->value = $node->filter('.package-description')->text();
    }
}
// phpcs:enable

/**
 * {@inheritDoc}
 */
final class AbstractSnippetTest extends TestCase
{
    private TestCrawler $crawler;
    private TestSnippet $snippet;

    /**
     * {@inheritDoc}
     */
    protected function setUp() : void
    {
        $this->crawler = new TestCrawler();
        $this->crawler->load();
        $this->snippet = new TestSnippet();
    }

    /**
     * {@inheritDoc}
     */
    public function testParse() : void
    {
        $this->snippet->scrape($this->crawler->dom()->filter('.package'));
        $value = $this->snippet->value();
        $this->assertNotEmpty($value);
        $this->assertIsString($value);
        $this->assertTrue(strlen($value) > 0);
    }
}
