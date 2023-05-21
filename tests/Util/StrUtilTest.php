<?php

/*
 * This file is part of the Monark IT project.
 *
 * (c) Monark IT <dev@monarkit.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Util;

use App\Util\StrUtil;
use PHPUnit\Framework\TestCase;

class StrUtilTest extends TestCase
{
    public function testSlugify(): void
    {
        $this->assertSame('hello-world', StrUtil::slugify('Hello World'));
        $this->assertSame('hello-world', StrUtil::slugify('Hello World!'));
        $this->assertSame('a-b-c-d-e', StrUtil::slugify('a b c d e'));
        $this->assertSame('hello-world', StrUtil::slugify('Hello_World'));
        $this->assertSame('symblog', StrUtil::slugify('symblog '));
    }

    public function testTruncate(): void
    {
        $this->assertSame('Hello World', StrUtil::truncate('Hello World'));
        $this->assertSame('Hello World', StrUtil::truncate('Hello World', 11));
        $this->assertSame('Lorem ipsu...', StrUtil::truncate('Lorem ipsum dolor sit amet', 10));
    }
}
