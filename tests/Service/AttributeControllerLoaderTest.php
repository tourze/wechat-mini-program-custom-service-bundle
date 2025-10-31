<?php

declare(strict_types=1);

namespace WechatMiniProgramCustomServiceBundle\Tests\Service;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractIntegrationTestCase;
use WechatMiniProgramCustomServiceBundle\Service\AttributeControllerLoader;

/**
 * AttributeControllerLoader服务测试
 * @internal
 */
#[CoversClass(AttributeControllerLoader::class)]
#[RunTestsInSeparateProcesses]
class AttributeControllerLoaderTest extends AbstractIntegrationTestCase
{
    private AttributeControllerLoader $loader;

    protected function onSetUp(): void
    {
        $this->loader = self::getService(AttributeControllerLoader::class);
    }

    public function testAutoload(): void
    {
        $collection = $this->loader->autoload();

        // 验证返回的是 RouteCollection 并且可以正常操作
        // 测试集合的基本功能，而不是类型
        self::assertSame(0, $collection->count()); // 在测试环境中通常为0
    }

    public function testLoad(): void
    {
        $collection = $this->loader->load('some_resource');

        // 验证load方法与autoload方法行为一致
        self::assertSame(0, $collection->count()); // 在测试环境中通常为0
    }

    public function testSupports(): void
    {
        // 根据设计，这个loader不直接支持任何资源类型
        self::assertFalse($this->loader->supports('any_resource'));
        self::assertFalse($this->loader->supports('any_resource', 'any_type'));
    }
}
