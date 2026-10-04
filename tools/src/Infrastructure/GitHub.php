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

use Cache\Adapter\Filesystem\FilesystemCachePool;
use Github\Client;
use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use YasumiDoc\Services\GitRepositoryInterface;

final readonly class GitHub implements GitRepositoryInterface
{
    private const string CACHE_FOLDER = '.cache/github';

    private Client $client;

    public function __construct(private string $username, private string $repository)
    {
        $this->client = new Client();

        // The Flysystem root is the project root, so the cache stays out of the source tree.
        $filesystem = new Filesystem(new LocalFilesystemAdapter(\dirname(__DIR__, 2)));

        $pool = new FilesystemCachePool($filesystem, self::CACHE_FOLDER);

        $this->client->addCache($pool);
    }

    public function fetchReleases(): array
    {
        return array_map(
            static fn (array $release): array => [
                'name' => $release['name'],
                'notes' => $release['body'],
                'published_at' => $release['published_at'],
                'tag' => $release['tag_name'],
                'url' => $release['html_url'],
            ],
            $this->client->repo()->releases()->all($this->username, $this->repository)
        );
    }
}
