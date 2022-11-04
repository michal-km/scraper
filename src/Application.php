<?php declare(strict_types=1);

/*
 * This file is part of the recruitment exercise.
 *
 * @author Michal Kazmierczak <michal.kazmierczak@oldwestenterprises.pl>
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App;

use Symfony\Component\Console\Application as ConsoleApplication;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * {@inheritdoc}
 */
class Application extends ConsoleApplication
{
    /**
     * {@inheritdoc}
     */
    public function __construct(iterable $commands = [])
    {
        parent::__construct('WL Site Scrapper', "1.0.0");
        foreach ($commands as $command) {
            $this->add($command);
        }
    }
}
