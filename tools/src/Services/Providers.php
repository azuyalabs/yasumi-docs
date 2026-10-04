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

namespace YasumiDoc\Services;

use Yasumi\Holiday;
use Yasumi\SubstituteHoliday;
use Yasumi\Yasumi;

final readonly class Providers implements ProvidersInterface
{
    private const array INCOMPLETE_PROVIDERS = [
        'IR' => 'Islamic lunar calendar holidays (e.g. Eid al-Fitr, Eid al-Adha) are not yet calculated by Yasumi and are therefore not listed.',
        'TR' => 'Islamic lunar calendar holidays (e.g. Eid al-Fitr, Eid al-Adha) are not yet calculated by Yasumi and are therefore not listed.',
        'KE' => 'Islamic lunar calendar holidays (e.g. Eid al-Fitr, Eid al-Adha) are not yet calculated by Yasumi and are therefore not listed.',
    ];

    public function __construct(
        private LocaleInterface $locale,
    ) {
    }

    public function fetchStatistics(): array
    {
        $providers = Yasumi::getProviders();
        sort($providers);

        $subRegionCount = count(array_filter(
            $providers,
            static fn (string $provider): bool => str_contains($provider, '/')
        ));

        return [
            'regions' => count($providers) - $subRegionCount,
            'sub-regions' => $subRegionCount,
            'total' => count($providers),
        ];
    }

    public function fetchProviders(): array
    {
        $providers = Yasumi::getProviders();
        asort($providers);

        return $providers;
    }

    public function fetchTopLevelProviders(): array
    {
        return array_filter(
            $this->fetchProviders(),
            static fn (string $p): bool => ! str_contains($p, '-'),
            ARRAY_FILTER_USE_KEY
        );
    }

    public function fetchProviderData(string $code): array
    {
        $data = [];
        try {
            $provider = Yasumi::createByISO3166_2($code, (int) \date('Y'));
            $provParts = \explode('\\', $provider::class);

            if (isset($provParts[3])) {
                $name = $this->locale->translateSubdivision($provParts[2] . '/' . $provParts[3]);
                $parent = $this->locale->translateSubdivision($provParts[2]);
            } else {
                $name = $this->locale->translateSubdivision(new \ReflectionClass($provider)->getShortName());
                $parent = null;
            }

            $holidays = array_map(static fn (Holiday $holiday): array => [
                'date' => $holiday,
                'day_of_week' => $holiday->format('l'),
                'is_observed' => SubstituteHoliday::class === $holiday::class,
                'name' => $holiday->getName(),
                'type' => $holiday->getType(),
            ], $provider->getHolidays());

            // Deduplicate holidays by date + name to handle providers that register
            // the same holiday under multiple keys (e.g. deprecated key aliases).
            $list = [];
            $holidays = array_values(array_filter(
                $holidays,
                static function (array $holiday) use (&$list): bool {
                    $key = $holiday['date']->format('Y-m-d') . $holiday['name'];
                    if (isset($list[$key])) {
                        return false;
                    }
                    $list[$key] = true;

                    return true;
                }
            ));

            $data = [
                'count' => count($holidays),
                'holidays' => $holidays,
                'incomplete' => self::INCOMPLETE_PROVIDERS[strtoupper($code)] ?? null,
                'name' => $name,
                'parent' => $parent,
                'sources' => $provider->getSources(),
            ];
        } catch (\ReflectionException $e) {
            error_log(sprintf('Provider data fetch failed: %s', $e->getMessage()));
        }

        return $data;
    }
}
