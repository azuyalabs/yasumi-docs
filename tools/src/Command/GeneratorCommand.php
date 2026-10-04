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
use YasumiDoc\Generator\CommonPagesGenerator;
use YasumiDoc\Generator\CookbookPagesGenerator;
use YasumiDoc\Generator\ProvidersPageGenerator;
use YasumiDoc\Generator\ReleasesPagesGenerator;
use YasumiDoc\Generator\TestingPageGenerator;

final readonly class GeneratorCommand
{
    public function __construct(
        private CommonPagesGenerator $commonPagesGenerator,
        private ProvidersPageGenerator $providersPageGenerator,
        private TestingPageGenerator $testingPageGenerator,
        private CookbookPagesGenerator $cookbookPagesGenerator,
        private ReleasesPagesGenerator $releasesPagesGenerator,
    ) {
    }

    public function __invoke(InputInterface $input, OutputInterface $output): void
    {
        $io = new SymfonyStyle($input, $output);
        $q = new \SplQueue();

        $q->enqueue($this->commonPagesGenerator);
        $q->enqueue($this->providersPageGenerator);
        $q->enqueue($this->testingPageGenerator);
        $q->enqueue($this->cookbookPagesGenerator);
        $q->enqueue($this->releasesPagesGenerator);

        while (false === $q->isEmpty()) {
            $generator = $q->dequeue();

            if (0 === $generator->execute()) {
                $io->success(
                    sprintf('generated the %s', $this->extractGeneratorName((string) $generator))
                );
            } else {
                $io->error(sprintf('unable to generate the %s', (string) $generator));
            }
        }
    }

    private function extractGeneratorName(string $class): string
    {
        $parts = preg_split('/(?=[A-Z])/', $class, -1, \PREG_SPLIT_NO_EMPTY);

        return mb_strtolower(implode(' ', array_diff($parts, ['Generator'])));
    }
}
