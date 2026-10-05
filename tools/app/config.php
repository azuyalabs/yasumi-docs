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

use Http\Discovery\Psr18Client;
use Psr\Http\Client\ClientInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use YasumiDoc\BuildConfig;
use YasumiDoc\Infrastructure\GitHub;
use YasumiDoc\PageData;
use YasumiDoc\PageDataInterface;
use YasumiDoc\Services\GitRepositoryInterface;
use YasumiDoc\Services\LocaleInterface;
use YasumiDoc\Services\ProvidersInterface;
use YasumiDoc\Services\UnitTestsInterface;

return [
    Environment::class => static function (): Environment {
        $loader = new FilesystemLoader(__DIR__ . \DIRECTORY_SEPARATOR . '../templates');

        $humanFriendlyFilter = new Twig\TwigFilter(
            'human_friendly',
            [YasumiDoc\Helpers\NumberFormatter::class, 'humanFriendly']
        );

        $twig = new Environment($loader);
        $twig->addFilter($humanFriendlyFilter);

        return $twig;
    },

    BuildConfig::class => static fn (): BuildConfig => new BuildConfig(
        '../docs'
    ),

    GitRepositoryInterface::class => DI\autowire(GitHub::class)->constructor('azuyalabs', 'yasumi', DI\get(BuildConfig::class)),
    LocaleInterface::class => DI\autowire(YasumiDoc\Infrastructure\CLDR::class),
    UnitTestsInterface::class => DI\autowire(YasumiDoc\Services\UnitTests::class),
    ProvidersInterface::class => DI\autowire(YasumiDoc\Services\Providers::class),

    ClientInterface::class => static fn (): Psr18Client => new Psr18Client(),
    PageDataInterface::class => static fn (): PageData => new PageData(
        [
            'siteName' => 'Yasumi',
        ]
    ),
];
