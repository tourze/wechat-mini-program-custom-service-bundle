<?php

namespace WechatMiniProgramCustomServiceBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use WechatMiniProgramBundle\DataFixtures\AccountFixtures;
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramCustomServiceBundle\Entity\MpPageMessage;

#[When(env: 'test')]
#[When(env: 'dev')]
class MpPageMessageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $account = $this->getReference(AccountFixtures::class, Account::class);

        // 创建首页小程序卡片
        $mpPageMessage1 = new MpPageMessage();
        $mpPageMessage1->setAccount($account);
        $mpPageMessage1->setTouser('test_user_openid_001');
        $mpPageMessage1->setTitle('欢迎来到我们的小程序');
        $mpPageMessage1->setPagePath('pages/index/index');
        $mpPageMessage1->setThumbMediaId('homepage_thumb_media_001');

        $manager->persist($mpPageMessage1);

        // 创建产品详情页卡片
        $mpPageMessage2 = new MpPageMessage();
        $mpPageMessage2->setAccount($account);
        $mpPageMessage2->setTouser('test_user_openid_002');
        $mpPageMessage2->setTitle('查看产品详情');
        $mpPageMessage2->setPagePath('pages/product/detail?id=123');
        $mpPageMessage2->setThumbMediaId('product_thumb_media_002');

        $manager->persist($mpPageMessage2);

        // 创建用户中心卡片
        $mpPageMessage3 = new MpPageMessage();
        $mpPageMessage3->setAccount($account);
        $mpPageMessage3->setTouser('test_user_openid_003');
        $mpPageMessage3->setTitle('个人中心');
        $mpPageMessage3->setPagePath('pages/user/profile');
        $mpPageMessage3->setThumbMediaId('profile_thumb_media_003');

        $manager->persist($mpPageMessage3);

        // 创建活动页面卡片
        $mpPageMessage4 = new MpPageMessage();
        $mpPageMessage4->setAccount($account);
        $mpPageMessage4->setTouser('test_user_openid_004');
        $mpPageMessage4->setTitle('限时优惠活动');
        $mpPageMessage4->setPagePath('pages/activity/promotion?type=flash&id=456');
        $mpPageMessage4->setThumbMediaId('activity_thumb_media_004');

        $manager->persist($mpPageMessage4);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AccountFixtures::class,
        ];
    }
}
