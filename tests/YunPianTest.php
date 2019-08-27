<?php

/*
 * This file is part of the mitirrli/YunPian
 *
 * (c) mitirrli <512663808@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Mitirrli\YunPian\Tests;

use Mitirrli\YunPian\YunPian;
use PHPUnit\Framework\TestCase;

class YunPianTest extends TestCase
{
    public function testSetGuzzleOptions()
    {
        $w = new YunPian('mock-key', 'mock-tpl');

        // 设置参数前，timeout 为 null
        $this->assertNull($w->getHttpClient()->getConfig('timeout'));

        // 设置参数
        $w->setGuzzleOptions(['timeout' => 5000]);

        // 设置参数后，timeout 为 5000
        $this->assertSame(5000, $w->getHttpClient()->getConfig('timeout'));
    }
}
