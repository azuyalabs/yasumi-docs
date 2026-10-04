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

use DI\ContainerBuilder;

require __DIR__ . \DIRECTORY_SEPARATOR . '../vendor/autoload.php';

$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . \DIRECTORY_SEPARATOR . 'config.php');

try {
    return $builder->build();
} catch (Exception $e) {
    error_log(sprintf('Container build failed: %s', $e->getMessage()));
    exit(1);
}
