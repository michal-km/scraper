<?php

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
use App\Scraper\Scraper;

/**
 * Scrapper command
 */
#[AsCommand(name: 'get')]
class ScrapeCommand extends Command
{
    private Scraper $scraper;
    /**
     * {@inheritdoc}
     */
    public function __construct(Scraper $scraper)
    {
        $this->scraper = $scraper;
        parent::__construct();
    }

    /**
     * {@inheritdoc}
     */
    protected function configure() : void
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
        try {
            $url = $input->getArgument('url');
            $options = $this->scraper->scrape($url);
            $json = json_encode($options, JSON_PRETTY_PRINT);
            $output->writeln(sprintf("%s", $json));

            return Command::SUCCESS;
        } catch (\Exception $e) {
            // send email
            // log error
            print $e->getMessage();

            return Command::FAILURE;
        }
    }
}
