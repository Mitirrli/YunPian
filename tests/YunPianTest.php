<?php

namespace Mitirrli\YunPian\tests;

use Mitirrli\YunPian\YunPian;
use PHPUnit\Framework\TestCase;

class YunPianTest extends TestCase
{
    public function testGetHttpClient()
    {
        $w = new YunPian('mock-key','test');

        // 设置参数前，timeout 为 null
        $this->assertNull($w->getHttpClient()->getConfig('timeout'));

        // 设置参数
        $w->setGuzzleOptions(['timeout' => 5000]);

        // 设置参数后，timeout 为 5000
        $this->assertSame(5000, $w->getHttpClient()->getConfig('timeout'));
    }
}
