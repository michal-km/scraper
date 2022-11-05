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
class DescriptionSnippet extends AbstractSnippet
{
    public const OPTION_NAME = "description";

    /**
     * {@inheritDoc}
     */
    protected function parse($node): void
    {
        $this->value = $node->filter('.package-name')->text();
        $this->value .= " " . $node->filter('.package-description')->text();
    }
}
