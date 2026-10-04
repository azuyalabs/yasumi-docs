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

use Twig\Environment;
use YasumiDoc\BuildConfig;
use YasumiDoc\PageDataInterface;
use YasumiDoc\Services\UnitTestsInterface;

final class TestingPageGenerator extends AbstractPageGenerator
{
    public function __construct(
        protected Environment $twig,
        protected PageDataInterface $pageData,
        protected BuildConfig $config,
        private readonly UnitTestsInterface $unitTests,
    ) {
        parent::__construct($twig, $pageData, $config);
    }

    public function execute(): int
    {
        $this->pageData->set('tests_count', $this->unitTests->fetchCounts());
        $this->pageData->set('test_suites', $this->unitTests->fetchSuites());

        $this->generate('developers/testing');

        return self::SUCCESS;
    }
}
