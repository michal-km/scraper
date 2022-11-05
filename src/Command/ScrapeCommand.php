<?php

declare(strict_types=1);

/*
 * This file is part of the recruitment exercise.
 *
 * @author Michal Kazmierczak <michal.kazmierczak@oldwestenterprises.pl>
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\HttpKernel\Log\Logger;
use Psr\Log\LoggerInterface;
use App\Scraper\Scraper;

/**
 * Scrapper command
 */
#[AsCommand(name: 'get')]
class ScrapeCommand extends Command
{
    private Scraper $scraper;
    private LoggerInterface $logger;
    /**
     * {@inheritdoc}
     */
    public function __construct(Scraper $scraper, LoggerInterface $logger)
    {
        $this->scraper = $scraper;
        $this->logger = $logger;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
        $this->setDescription('Scrape a website and produce a JSON array.')
            ->setHelp('Help message')
            ->addArgument('url', InputArgument::OPTIONAL, 'Url of the website to scrape from.');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $returnCode = Command::SUCCESS;
        try {
            $this->logger->info('Scraping session started.');
            $json = $this->getJson($input->getArgument('url'));
            $output->writeln(sprintf("%s", $json));
        } catch (\Exception $e) {
            /**
             * In production scraper, an email message should be sent whennever an scraping issue appears.
             * For the purpose of this exercise, errors are logged.
             */
            $this->logger->error($e->getMessage());
            $returnCode = Command::FAILURE;
        } finally {
            $this->logger->info('Scraping session ended.');
        }

        return $returnCode;
    }

    /**
     * @param ?string $url An URL of website to scrap from.
     *
     * @return string JSON with the scraping results.
     */
    private function getJson(?string $url): string
    {
        if (empty($url)) {
            $url = "https://wltest.dns-systems.net/";
        }
        $this->logger->info(sprintf("Connecting to %s.", $url));
        $options = $this->scraper->scrape($url);
        if (empty($options)) {
            $this->logger->warning('No data scraped.');
        } else {
            $options = array_values($options);
        }

        return json_encode($options, JSON_PRETTY_PRINT);
    }
}
