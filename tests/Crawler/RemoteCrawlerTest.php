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
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use App\Crawler\RemoteCrawler;

/**
 * RemoteCrawler unit test.
 */
final class RemoteCrawlerTest extends TestCase
{
    private RemoteCrawler $crawler;

    /**
     * {@inheritDoc}
     */
    protected function setUp(): void
    {
        $container = new ContainerBuilder();
        $loader = new YamlFileLoader($container, new FileLocator());
        $loader->load(__DIR__.'/../../config/services.yml');
        $container->compile();
        $this->crawler = $container->get(\App\Crawler\RemoteCrawler::class);
    }

    /**
     * All crawlers should be descendants of \Symfony\Component\DomCrawler\Crawler.
     */
    public function testConstructor() : void
    {
        $this->assertInstanceOf("\Symfony\Component\DomCrawler\Crawler", $this->crawler);
    }

    /**
     * RemoteCrawler fetches data from a real website and it is not desirable to do it in every testing session.
     * Therefore. load function test is simplified.
     */
    public function testLoad() : void
    {
        $this->crawler->load(null);
        $text = $this->crawler->filter(".info")->text();
        $this->assertSame("Empty document", $text);
    }
}
