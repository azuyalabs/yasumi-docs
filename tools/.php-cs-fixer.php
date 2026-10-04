<?php

declare(strict_types = 1);

/**
 * This file is part of the 'yasumi-docs' package.
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

$config = new AzuyaLabs\PhpCsFixerConfig\Config(null, null, 'Yasumi Docs');
$config->getFinder()->in(__DIR__)->append(['build']);

return $config;
