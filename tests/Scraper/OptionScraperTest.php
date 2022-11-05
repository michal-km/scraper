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
use App\Scraper\OptionScraper;

/**
 * {@inheritdoc}
 */
final class OptionScraperTest extends TestCase
{
    private OptionScraper $optionScraper;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $container = new ContainerBuilder();
        $loader = new YamlFileLoader($container, new FileLocator());
        $loader->load(__DIR__ . '/../../config/services.test.yml');
        $container->compile();
        $this->optionScraper = $container->get(\App\Scraper\OptionScraper::class);
    }

    /**
     * Test of two methods:
     * * getProperties() : array
     * * getProperty(string $name) : mixed
     */
    public function testProperties(): void
    {
        $properties = $this->optionScraper->getProperties();
        $this->assertIsArray($properties);
        $this->assertNotEmpty($properties);
        foreach ($properties as $name => $value) {
            $this->assertSame($value, $this->optionScraper->getProperty($name));
        }
    }
}
