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
use YasumiDoc\Services\GitRepositoryInterface;

final class ReleasesPagesGenerator extends AbstractPageGenerator
{
    public function __construct(
        protected Environment $twig,
        protected PageDataInterface $pageData,
        protected BuildConfig $config,
        protected GitRepositoryInterface $repo,
    ) {
        parent::__construct($twig, $pageData, $config);
    }

    public function execute(): int
    {
        $releases = $this->repo->fetchReleases();

        $this->pageData->set('releases', $releases);
        $this->generate('releases/index');

        foreach ($releases as $release) {
            $this->pageData->set('release', $release);
            $this->generate('releases/release', sprintf('releases/%s', $release['tag']));
        }

        return self::SUCCESS;
    }
}
