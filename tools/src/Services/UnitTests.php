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

use Symfony\Component\Finder\Finder;
use Yasumi\Yasumi;

final readonly class UnitTests implements UnitTestsInterface
{
    public function __construct(private LocaleInterface $locale)
    {
    }

    public function fetchCounts(): int
    {
        $test_count = 0;

        foreach ($this->findTestFiles() as $file) {
            try {
                $r = new \ReflectionClass('Yasumi\\tests\\' . \str_replace(
                    '/',
                    '\\',
                    $file->getRelativePath()
                ) . '\\' . $file->getBasename('.php'));

                $methods = $r->getMethods();
                \array_walk($methods, static function (\ReflectionMethod $k) use (&$test_count): void {
                    if (str_starts_with($k->getName(), 'test')) {
                        ++$test_count;
                    }
                });
            } catch (\ReflectionException $re) {
                echo $re->getMessage();
            }
        }

        return $test_count;
    }

    public function fetchSuites(): array
    {
        $suites = [];
        $providers = Yasumi::getProviders();
        \sort($providers);

        foreach ($providers as $provider) {
            $pParts = \explode('/', $provider);

            if (! isset($pParts[2]) && ! isset($pParts[1])) {
                $r = new \ReflectionClass('Yasumi\\Provider\\' . \str_replace('/', '\\', $provider));

                $suites[\strtolower((string) $r->getConstant('ID'))] = [
                    'suite' => $provider,
                    'name' => $this->locale->translateSubdivision($provider),
                ];
            }
        }

        return $suites;
    }

    private function findTestFiles(): Finder
    {
        $finder = new Finder();
        $finder->files()->in('vendor/azuyalabs/yasumi/tests/')
            ->exclude('Base')
            ->name('*.php')
            ->notName('YasumiBase.php')
            ->notName('ProviderTestCase.php')
            ->notName('Randomizer.php')
            ->notName('HolidayTestCase.php');

        return $finder;
    }
}
