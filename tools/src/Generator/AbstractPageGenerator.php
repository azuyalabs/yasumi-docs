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

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Path;
use Twig\Environment;
use YasumiDoc\BuildConfig;
use YasumiDoc\PageDataInterface;

abstract class AbstractPageGenerator implements PageGeneratorInterface, \Stringable
{
    // see https://tldp.org/LDP/abs/html/exitcodes.html
    public const SUCCESS = 0;

    public const FAILURE = 1;

    public const INVALID = 2;

    public function __construct(
        protected Environment $twig,
        protected PageDataInterface $pageData,
        protected BuildConfig $config,
    ) {
    }

    public function __toString(): string
    {
        return new \ReflectionClass($this)->getShortName();
    }

    protected function generate(string $template, ?string $filename = null): void
    {
        $filename ??= $template;

        $outputFile = sprintf('%s/%s.md', $this->config->getOutputDir(), $filename);
        $outputDir = Path::getDirectory($outputFile);

        new Filesystem()->mkdir($outputDir); // create the directory in case the template is in a subdirectory

        $contents = $this->twig->render(sprintf('%s.twig.md', $template), $this->pageData->all());
        file_put_contents($outputFile, $contents);
    }
}
