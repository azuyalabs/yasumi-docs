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
use YasumiDoc\Services\ProvidersInterface;

final class ProvidersPageGenerator extends AbstractPageGenerator
{
    public function __construct(
        protected Environment $twig,
        protected PageDataInterface $pageData,
        protected BuildConfig $config,
        private readonly ProvidersInterface $providers,
    ) {
        parent::__construct($twig, $pageData, $config);
    }

    public function execute(): int
    {
        $providers = $this->providers->fetchProviders();

        $this->pageData
            ->set('provider_stats', $this->providers->fetchStatistics())
            ->set('providers', $providers)
            ->set('id_list', '#' . implode(', #', array_keys($this->providers->fetchTopLevelProviders())));

        $this->generate('providers/providers');

        foreach (array_keys($providers) as $id) {
            $this->pageData->set('provider', $this->providers->fetchProviderData($id));
            $this->generate('providers/provider', sprintf('providers/%s', strtolower((string) $id)));
        }

        return self::SUCCESS;
    }
}
