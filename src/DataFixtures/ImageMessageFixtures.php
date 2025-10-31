<?php

namespace WechatMiniProgramCustomServiceBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use WechatMiniProgramBundle\DataFixtures\AccountFixtures;
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramCustomServiceBundle\Entity\ImageMessage;

#[When(env: 'test')]
#[When(env: 'dev')]
class ImageMessageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $account = $this->getReference(AccountFixtures::class, Account::class);

        // 创建测试用的图片消息
        $imageMessage1 = new ImageMessage();
        $imageMessage1->setAccount($account);
        $imageMessage1->setTouser('test_user_openid_001');
        $imageMessage1->setMediaId('test_media_id_001');

        $manager->persist($imageMessage1);

        $imageMessage2 = new ImageMessage();
        $imageMessage2->setAccount($account);
        $imageMessage2->setTouser('test_user_openid_002');
        $imageMessage2->setMediaId('test_media_id_002');

        $manager->persist($imageMessage2);

        // 创建一个不同类型的测试图片消息
        $imageMessage3 = new ImageMessage();
        $imageMessage3->setAccount($account);
        $imageMessage3->setTouser('test_user_openid_003');
        $imageMessage3->setMediaId('screenshot_media_id_003');

        $manager->persist($imageMessage3);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AccountFixtures::class,
        ];
    }
}
