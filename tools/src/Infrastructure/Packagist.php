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

namespace YasumiDoc\Infrastructure;

use GuzzleHttp\Client;
use Spatie\Packagist\PackagistClient;
use Spatie\Packagist\PackagistUrlGenerator;
use YasumiDoc\Services\PackageRepositoryInterface;

final readonly class Packagist implements PackageRepositoryInterface
{
    private PackagistClient $packagist;

    public function __construct()
    {
        $this->packagist = new PackagistClient(new Client(), new PackagistUrlGenerator());
    }

    public function fetchNumberOfDownloads(string $vendor, string $package): int
    {
        try {
            $meta = $this->packagist->getPackage($vendor . '/' . $package);

            return $meta['package']['downloads']['total'] ?? 0;
        } catch (\Exception $e) {
            error_log(sprintf('Packagist fetch failed: %s', $e->getMessage()));

            return 0;
        }
    }
}
