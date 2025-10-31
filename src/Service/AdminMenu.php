<?php

declare(strict_types=1);

namespace WechatMiniProgramCustomServiceBundle\Service;

use Knp\Menu\ItemInterface;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Tourze\EasyAdminMenuBundle\Service\LinkGeneratorInterface;
use Tourze\EasyAdminMenuBundle\Service\MenuProviderInterface;
use WechatMiniProgramCustomServiceBundle\Entity\ImageMessage;
use WechatMiniProgramCustomServiceBundle\Entity\LinkMessage;
use WechatMiniProgramCustomServiceBundle\Entity\MpPageMessage;
use WechatMiniProgramCustomServiceBundle\Entity\TextMessage;

/**
 * 小程序客服消息管理后台菜单提供者
 */
#[Autoconfigure(public: true)]
readonly class AdminMenu implements MenuProviderInterface
{
    public function __construct(
        private LinkGeneratorInterface $linkGenerator,
    ) {
    }

    public function __invoke(ItemInterface $item): void
    {
        if (null === $item->getChild('微信管理')) {
            $item->addChild('微信管理');
        }

        $wechatMenu = $item->getChild('微信管理');
        if (null === $wechatMenu) {
            return;
        }

        // 添加小程序客服消息管理子菜单
        if (null === $wechatMenu->getChild('小程序客服消息')) {
            $wechatMenu->addChild('小程序客服消息')
                ->setAttribute('icon', 'fas fa-comments')
            ;
        }

        $messageMenu = $wechatMenu->getChild('小程序客服消息');
        if (null === $messageMenu) {
            return;
        }

        $messageMenu->addChild('文本消息')
            ->setUri($this->linkGenerator->getCurdListPage(TextMessage::class))
            ->setAttribute('icon', 'fas fa-comment-alt')
        ;

        $messageMenu->addChild('图片消息')
            ->setUri($this->linkGenerator->getCurdListPage(ImageMessage::class))
            ->setAttribute('icon', 'fas fa-image')
        ;

        $messageMenu->addChild('链接消息')
            ->setUri($this->linkGenerator->getCurdListPage(LinkMessage::class))
            ->setAttribute('icon', 'fas fa-link')
        ;

        $messageMenu->addChild('小程序卡片消息')
            ->setUri($this->linkGenerator->getCurdListPage(MpPageMessage::class))
            ->setAttribute('icon', 'fas fa-window-restore')
        ;
    }
}
