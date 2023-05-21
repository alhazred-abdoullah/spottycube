<?php

/*
 * This file is part of the Monark IT project.
 *
 * (c) Monark IT <dev@monarkit.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Util;

class StrUtil
{
    public static function slugify(string $str): string
    {
        $str = preg_replace('/[^a-z0-9]+/i', '-', $str);
        $str = trim(sprintf('%s', $str), '-');

        return mb_strtolower($str);
    }

    public static function truncate(string $str, int $length = 30, string $end = '...'): string
    {
        if (mb_strlen($str) > $length) {
            $str = mb_substr($str, 0, $length).$end;
        }

        return $str;
    }
}
