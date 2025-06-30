<?php

namespace WechatMiniProgramCustomServiceBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use WechatMiniProgramCustomServiceBundle\DependencyInjection\WechatMiniProgramCustomServiceExtension;

class WechatMiniProgramCustomServiceExtensionTest extends TestCase
{
    public function testLoad(): void
    {
        $container = new ContainerBuilder();
        $extension = new WechatMiniProgramCustomServiceExtension();
        
        $extension->load([], $container);
        
        // 验证服务是否被加载
        $this->assertTrue($container->has('WechatMiniProgramCustomServiceBundle\Repository\TextMessageRepository'));
        $this->assertTrue($container->has('WechatMiniProgramCustomServiceBundle\Repository\ImageMessageRepository'));
        $this->assertTrue($container->has('WechatMiniProgramCustomServiceBundle\Repository\LinkMessageRepository'));
        $this->assertTrue($container->has('WechatMiniProgramCustomServiceBundle\Repository\MpMessageRepository'));
        $this->assertTrue($container->has('WechatMiniProgramCustomServiceBundle\EventSubscriber\MessageListener'));
    }
}