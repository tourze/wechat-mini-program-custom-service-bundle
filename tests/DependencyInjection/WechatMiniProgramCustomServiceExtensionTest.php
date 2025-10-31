<?php

declare(strict_types=1);

namespace WechatMiniProgramCustomServiceBundle\Tests\DependencyInjection;

use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tourze\PHPUnitSymfonyUnitTest\AbstractDependencyInjectionExtensionTestCase;
use WechatMiniProgramCustomServiceBundle\DependencyInjection\WechatMiniProgramCustomServiceExtension;

/**
 * @internal
 */
#[CoversClass(WechatMiniProgramCustomServiceExtension::class)]
final class WechatMiniProgramCustomServiceExtensionTest extends AbstractDependencyInjectionExtensionTestCase
{
    protected function setUp(): void
    {
        // 集成测试不需要额外的设置
    }

    public function testServiceConfiguration(): void
    {
        $container = new ContainerBuilder();
        $container->setParameter('kernel.environment', 'test');
        $extension = new WechatMiniProgramCustomServiceExtension();

        $extension->load([], $container);

        $this->assertTrue($container->has('WechatMiniProgramCustomServiceBundle\Repository\TextMessageRepository'));
        $this->assertTrue($container->has('WechatMiniProgramCustomServiceBundle\Repository\ImageMessageRepository'));
        $this->assertTrue($container->has('WechatMiniProgramCustomServiceBundle\Repository\LinkMessageRepository'));
        $this->assertTrue($container->has('WechatMiniProgramCustomServiceBundle\Repository\MpMessageRepository'));
        $this->assertTrue($container->has('WechatMiniProgramCustomServiceBundle\EventSubscriber\MessageListener'));
    }
}
