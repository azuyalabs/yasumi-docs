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

namespace YasumiDoc\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Twig\Environment;
use YasumiDoc\BuildConfig;
use YasumiDoc\Services\GitRepositoryInterface;
use YasumiDoc\Services\LocaleInterface;
use YasumiDoc\Services\ProvidersInterface;

final readonly class ConfigurationCommand
{
    private const string MKDOCS_CONF_FILE = 'mkdocs.yml';

    private const string MKDOCS_CONF_TPL = 'mkdocs.twig.yml';

    public function __construct(
        private Environment $twig,
        private BuildConfig $config,
        private GitRepositoryInterface $repo,
        private ProvidersInterface $providers,
        private LocaleInterface $locale,
    ) {
    }

    public function __invoke(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);

        $templateData = [
            'releases' => $this->repo->fetchReleases(),
            'providers' => $this->getTopLevelProviders(),
        ];

        $configPath = dirname($this->config->getOutputDir()) . '/' . self::MKDOCS_CONF_FILE;

        file_put_contents(
            $configPath,
            $this->twig->render(self::MKDOCS_CONF_TPL, $templateData)
        );

        $io->success('generated MKDocs configuration file');
    }

    public function getTopLevelProviders(): array
    {
        return array_map(
            $this->locale->translateSubdivision(...),
            $this->providers->fetchTopLevelProviders()
        );
    }
}
