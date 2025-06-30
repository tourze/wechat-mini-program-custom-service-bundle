<?php

declare(strict_types=1);

namespace WechatMiniProgramCustomServiceBundle\Tests\Unit;

use PHPUnit\Framework\TestCase;
use WechatMiniProgramCustomServiceBundle\WechatMiniProgramCustomServiceBundle;

class WechatMiniProgramCustomServiceBundleTest extends TestCase
{
    public function testBundleIsInstantiable(): void
    {
        $bundle = new WechatMiniProgramCustomServiceBundle();
        
        $this->assertInstanceOf(WechatMiniProgramCustomServiceBundle::class, $bundle);
    }
}