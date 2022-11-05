<?php

declare(strict_types=1);

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
class PriceSnippet extends AbstractSnippet
{
    public const OPTION_NAME = "price";
    public const OPTION_REQUIRED = true;

    /**
     * {@inheritDoc}
     */
    protected function parse($node): void
    {
        $value = $node->filter('.price-big')->text();
        $value = preg_replace("#[^\d\.]#", "", $value);
        $value = round($value * 100);
        // monthly or yearly payment?
        $rate = $node->filter('.package-price')->text();
        if (false !== strpos($rate, "Per Month")) {
            $value *= 12;
        }

        $this->value = ($value/100);
    }
}
