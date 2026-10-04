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

namespace YasumiDoc;

use Symfony\Component\Filesystem\Filesystem;

final class BuildConfig
{
    private const string OUTPUT_DIR = '..';

    public function __construct(private ?string $outputDir = self::OUTPUT_DIR)
    {
        $this->setOutputDir($outputDir);
    }

    public function getOutputDir(): string
    {
        return $this->outputDir;
    }

    private function setOutputDir(string $outputDir): self
    {
        (new Filesystem())->mkdir($outputDir);
        if (false === file_exists($outputDir)) {
            throw new \InvalidArgumentException(sprintf('builder output directory "%s" does not exist', $outputDir));
        }

        $this->outputDir = rtrim(realpath($outputDir), DIRECTORY_SEPARATOR);

        return $this;
    }
}
