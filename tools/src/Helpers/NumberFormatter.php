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

namespace YasumiDoc\Helpers;

final class NumberFormatter
{
    /**
     * Converts a numeric value into a human-readable string representation.
     * (e.g. 2100 becomes '2.1K').
     *
     * @param int $value     number the monetary value to be converted
     * @param int $precision the number of digits (precision) to use for display
     *
     * @return string the human-readable string representation of the given numerical value
     */
    public static function humanFriendly(int $value, int $precision = 1): string
    {
        if (0 === $value) {
            return '0';
        }

        $i = (int) \floor(\log($value) / \log(1000));
        $sizes = ['', 'K', 'M', 'B', 'T'];

        return \sprintf('%0.' . $precision . 'f', $value / (1000 ** $i)) . $sizes[$i];
    }
}
