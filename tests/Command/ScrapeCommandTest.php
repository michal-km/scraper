<?php declare(strict_types=1);

/*
 * This file is part of the recruitment exercise.
 *
 * @author Michal Kazmierczak <michal.kazmierczak@oldwestenterprises.pl>
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Tests\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Console\Tester\CommandTester;
use App\Crawler\TestCrawler;
use App\Scraper\Scraper;
use App\Command\ScrapeCommand;

/**
 * {@inheritdoc}
 */
class ScrapeCommandTest extends TestCase
{
    private $commandTester;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        $container = new ContainerBuilder();
        $loader = new YamlFileLoader($container, new FileLocator());
        $loader->load(__DIR__.'/../../config/services.yml');
        $container->compile();
        $application = $container->get(\App\Application::class);
        $command = $application->find('scrape');
        $this->commandTester = new CommandTester($command);
    }

    /**
     * {@inheritdoc}
     */
    public function testReturnCode()
    {
        $this->commandTester->execute([]);
        $this->commandTester->assertCommandIsSuccessful();
    }

    /**
     * {@inheritdoc}
     */
    public function testJson()
    {
        $this->commandTester->execute([]);
        $output = $this->commandTester->getDisplay();
        $this->assertJson($output);
    }

    /**
     * {@inheritdoc}
     */
    public function testJsonContent() : void
    {
        $this->commandTester->execute([]);
        $json = $this->commandTester->getDisplay();
        $options = json_decode($json, true);
        $this->assertSame(count($options) > 0, true);
        foreach ($options as $option) {
            $this->assertArrayHasKey('option title', $option);
            $this->assertArrayHasKey('description', $option);
            $this->assertArrayHasKey('price', $option);
            // discount key is optional
        }
    }

    /**
     * {@inheritdoc}
     */
    public function testSort() : void
    {
        $this->commandTester->execute([]);
        $json = $this->commandTester->getDisplay();
        $options = json_decode($json, true);
        $v = null;
        foreach ($options as $option) {
            $price = $option["price"];
            if (null !== $v) {
                $this->assertSame(($price <= $v), true);
            }
            $v = $price;
        }
    }
}
