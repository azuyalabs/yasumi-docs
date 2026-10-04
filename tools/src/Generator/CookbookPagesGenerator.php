<?php

declare(strict_types = 1);

/**
 * This file is part of the 'Yasumi Docs' package.
 *
 * The documentation project for the Yasumi library package..
 *
 * Copyright (c) 2015 - 2026 AzuyaLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Sacha Telgenhof <me at sachatelgenhof dot com>
 */

namespace YasumiDoc\Generator;

final class CookbookPagesGenerator extends AbstractPageGenerator
{
    private array $pages = [
        'basic',
        'between_filter',
        'custom_provider',
        'filters',
    ];

    public function execute(): int
    {
        foreach ($this->pages as $page) {
            $this->generate(sprintf('recipes/%s', $page));
        }

        return self::SUCCESS;
    }
}
