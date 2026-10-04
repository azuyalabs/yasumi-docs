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

use Psr\Http\Client\ClientInterface;
use YasumiDoc\Services\LocaleInterface;

final readonly class CLDR implements LocaleInterface
{
    private const string CLDR_VERSION = '48';

    private string $cache_dir;

    private string $cldr_dir;

    public function __construct(private ClientInterface $client)
    {
        if (! \class_exists(\ZipArchive::class)) {
            exit('The Zip PHP extension is not installed. Please install it and try again.');
        }

        $this->cache_dir = \getcwd() . '/.cache';
        if (! \is_dir($this->cache_dir) && ! \mkdir($this->cache_dir)) {
            exit('Unable to create the cache directory.');
        }

        $this->cldr_dir = $this->cache_dir . '/_cldr';
        if (! \is_dir($this->cldr_dir) && ! \mkdir($this->cldr_dir)) {
            exit('Unable to create the cldr directory.');
        }

        $tmpFile = $this->cache_dir . '/cldr_' . self::CLDR_VERSION . '_tmp.zip';
        $zipFile = $this->cache_dir . '/cldr_' . self::CLDR_VERSION . '.zip';

        if (false === \is_readable($zipFile)) {
            try {
                $response = $this->client->get('https://unicode.org/Public/cldr/' . self::CLDR_VERSION . '/core.zip');
                \file_put_contents($tmpFile, $response->getBody()->getContents());
                \rename($tmpFile, $zipFile);
            } catch (\Throwable $e) {
                if (\is_file($tmpFile)) {
                    \unlink($tmpFile);
                }

                throw $e;
            }
        }

        if (! $this->isExtracted($this->cldr_dir)) {
            $archive = new \ZipArchive();
            $archive->open($zipFile);
            $archive->extractTo($this->cldr_dir, ['common/main/en.xml', 'common/subdivisions/en.xml']);
            $archive->close();
        }
    }

    public function translateSubdivision(string $provider): string
    {
        $names = $this->getSubdivisions();
        $name = '';
        $ausSubSubdivisions = [];

        try {
            $r = new \ReflectionClass('Yasumi\\Provider\\' . \str_replace('/', '\\', $provider));
            $id = (string) $r->getConstant('ID');

            // Since CLDR 31, the subdivision codes have been changed to all have the bcp47 format.
            if (\strpos($provider, '/')) {
                $id = \strtolower($id);
                $id = \str_replace('-', '', $id);

                // Canary Islands are registered as 'IC' in CLDR, whereas ISO-3166-2 has it registered
                // as 'ES-CN'
                if ('escn' === $id) {
                    $id = 'IC';
                }
            }

            $name = $id;
            if (\array_key_exists($id, $names)) {
                $name = $names[$id];
            }

            // CLDR uses Czechia as the official country name, however in Yasumi
            // the name for the provider is 'CzechRepublic'
            if ('CZ' === $id) {
                $name = 'Czech Republic';
            }

            // Australia Sub-Subdivisions (not translated in CLDR)
            $ausSubSubdivisions['auqldbri'] = 'Queensland - Brisbane';
            $ausSubSubdivisions['autascn'] = 'Tasmania - Central North';
            $ausSubSubdivisions['autasfi'] = 'Tasmania - Flinders Island';
            $ausSubSubdivisions['autaski'] = 'Tasmania - King Island';
            $ausSubSubdivisions['autasne'] = 'Tasmania - Northeast';
            $ausSubSubdivisions['autasnw'] = 'Tasmania - Northwest';
            $ausSubSubdivisions['autasnwch'] = 'Tasmania - Northwest Circular Head';
            $ausSubSubdivisions['autassou'] = 'Tasmania - South';
            $ausSubSubdivisions['autassouse'] = 'Tasmania - South Southeast';

            if (\array_key_exists($id, $ausSubSubdivisions)) {
                $name = $ausSubSubdivisions[$id];
            }
        } catch (\ReflectionException $e) {
            error_log(sprintf('CLDR subdivision translation failed: %s', $e->getMessage()));
        }

        return $name;
    }

    /** @return array<string, string|null> */
    private function getSubdivisions(): array
    {
        $cached_subdivisions = $this->cache_dir . '/_subdivisions.php';
        $subdivisions = [];

        if (! \is_readable($cached_subdivisions)) {
            $main = new \DOMDocument();
            $main->load($this->cldr_dir . '/common/main/en.xml');

            foreach ($main->getElementsByTagName('territory') as $subdivision) {
                // Skip entries with an alternative entry
                if ('' !== $subdivision->getAttribute('alt') && '0' !== $subdivision->getAttribute('alt')) {
                    continue;
                }

                $subdivisions[$subdivision->getAttribute('type')] = $subdivision->nodeValue;
            }

            $main->load($this->cldr_dir . '/common/subdivisions/en.xml');
            foreach ($main->getElementsByTagName('subdivision') as $subdivision) {
                $subdivisions[$subdivision->getAttribute('type')] = $subdivision->nodeValue;
            }
            try {
                \file_put_contents($cached_subdivisions, \json_encode($subdivisions, \JSON_THROW_ON_ERROR));
            } catch (\JsonException $e) {
                echo $e->getMessage();
            }
        } else {
            try {
                $subdivisions = \json_decode(\file_get_contents($cached_subdivisions), true, 512, \JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                echo $e->getMessage();
            }
        }

        return $subdivisions;
    }

    private function isExtracted(string $dir): bool
    {
        return 2 !== count(scandir($dir));
    }
}
