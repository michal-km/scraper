<?php

/*
 * This file is part of the recruitment exercise.
 *
 * @author Michal Kazmierczak <michal.kazmierczak@oldwestenterprises.pl>
 *
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

namespace App\Scraper\Snippets;

/**
 * {@inheritDoc}
 */
class NameSnippet extends AbstractSnippet
{
    public const OPTION_NAME = "option title";
    public const OPTION_REQUIRED = true;

    /**
     * {@inheritDoc}
     */
    protected function parse($node) : void
    {
        $this->value = $node->filter('h3')->text();
    }
}
