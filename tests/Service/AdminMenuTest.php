<?php

declare(strict_types=1);

namespace WechatMiniProgramCustomServiceBundle\Tests\Service;

use Knp\Menu\MenuFactory;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyWebTest\AbstractEasyAdminMenuTestCase;
use WechatMiniProgramCustomServiceBundle\Service\AdminMenu;

/**
 * AdminMenu服务测试
 * @internal
 */
#[CoversClass(AdminMenu::class)]
#[RunTestsInSeparateProcesses]
class AdminMenuTest extends AbstractEasyAdminMenuTestCase
{
    protected function onSetUp(): void
    {
        // Setup for AdminMenu tests
    }

    public function testInvokeAddsMenuItems(): void
    {
        $container = self::getContainer();
        /** @var AdminMenu $adminMenu */
        $adminMenu = $container->get(AdminMenu::class);

        $factory = new MenuFactory();
        $rootItem = $factory->createItem('root');

        $adminMenu->__invoke($rootItem);

        // 验证菜单结构
        $wechatMenu = $rootItem->getChild('微信管理');
        self::assertNotNull($wechatMenu);

        $messageMenu = $wechatMenu->getChild('小程序客服消息');
        self::assertNotNull($messageMenu);

        self::assertNotNull($messageMenu->getChild('文本消息'));
        self::assertNotNull($messageMenu->getChild('图片消息'));
        self::assertNotNull($messageMenu->getChild('链接消息'));
        self::assertNotNull($messageMenu->getChild('小程序卡片消息'));
    }
}
