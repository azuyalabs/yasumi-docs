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

interface PageDataInterface
{
    /** Clears all parameters. */
    public function clear(): void;

    /** Adds parameters to the page dataparameters. */
    public function add(array $parameters): self;

    /** Gets all of the page data parameters. */
    public function all(): array;

    /** Gets a page data parameter. */
    public function get(string $key, mixed $default = null): mixed;

    /** Sets a  parameter */
    public function set(string $key, mixed $value): self;

    /** Returns true if the parameter is defined */
    public function has(string $key): bool;
}
