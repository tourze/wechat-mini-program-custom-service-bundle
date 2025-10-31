<?php

namespace WechatMiniProgramCustomServiceBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use WechatMiniProgramBundle\DataFixtures\AccountFixtures;
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramCustomServiceBundle\Entity\LinkMessage;

#[When(env: 'test')]
#[When(env: 'dev')]
class LinkMessageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $account = $this->getReference(AccountFixtures::class, Account::class);

        // 创建带缩略图的链接消息
        $linkMessage1 = new LinkMessage();
        $linkMessage1->setAccount($account);
        $linkMessage1->setTouser('test_user_openid_001');
        $linkMessage1->setTitle('微信开发者文档');
        $linkMessage1->setDescription('微信小程序开发官方文档，提供全面的开发指南和API参考');
        $linkMessage1->setUrl('https://developers.weixin.qq.com/miniprogram/dev/');
        $linkMessage1->setThumbUrl('https://res.wx.qq.com/wxdoc/dist/assets/img/logo.png');

        $manager->persist($linkMessage1);

        // 创建不带缩略图的链接消息
        $linkMessage2 = new LinkMessage();
        $linkMessage2->setAccount($account);
        $linkMessage2->setTouser('test_user_openid_002');
        $linkMessage2->setTitle('GitHub仓库');
        $linkMessage2->setDescription('查看项目源代码和文档');
        $linkMessage2->setUrl('https://github.com/example/project');

        $manager->persist($linkMessage2);

        // 创建产品推荐链接
        $linkMessage3 = new LinkMessage();
        $linkMessage3->setAccount($account);
        $linkMessage3->setTouser('test_user_openid_003');
        $linkMessage3->setTitle('最新产品发布');
        $linkMessage3->setDescription('了解我们最新发布的产品特性和功能更新');
        $linkMessage3->setUrl('https://weixin.qq.com/miniprogram');
        $linkMessage3->setThumbUrl('https://res.wx.qq.com/wxdoc/dist/assets/img/logo.png');

        $manager->persist($linkMessage3);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AccountFixtures::class,
        ];
    }
}
