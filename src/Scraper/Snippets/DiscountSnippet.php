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
class DiscountSnippet extends AbstractSnippet
{
    public const OPTION_NAME = "discount";

    /**
     * {@inheritDoc}
     */
    protected function parse($node) : void
    {
        $this->value = $node->filter('p[style="color: red"]')->text();
    }
}
