<?php

namespace WechatMiniProgramCustomServiceBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\Attribute\When;
use WechatMiniProgramBundle\DataFixtures\AccountFixtures;
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramCustomServiceBundle\Entity\TextMessage;

#[When(env: 'test')]
#[When(env: 'dev')]
class TextMessageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $account = $this->getReference(AccountFixtures::class, Account::class);

        // 创建欢迎消息
        $textMessage1 = new TextMessage();
        $textMessage1->setAccount($account);
        $textMessage1->setTouser('test_user_openid_001');
        $textMessage1->setContent('欢迎使用我们的小程序！如有任何问题，请随时联系客服。');

        $manager->persist($textMessage1);

        // 创建常见问题回复
        $textMessage2 = new TextMessage();
        $textMessage2->setAccount($account);
        $textMessage2->setTouser('test_user_openid_002');
        $textMessage2->setContent('感谢您的咨询！您的问题我们已经收到，客服人员会在24小时内回复您。如需紧急帮助，请拨打客服热线：400-123-4567。');

        $manager->persist($textMessage2);

        // 创建订单状态通知
        $textMessage3 = new TextMessage();
        $textMessage3->setAccount($account);
        $textMessage3->setTouser('test_user_openid_003');
        $textMessage3->setContent('您好！您的订单 #ORDER123456 已发货，快递单号：SF1234567890。预计2-3个工作日送达，请留意查收。');

        $manager->persist($textMessage3);

        // 创建促销活动通知
        $textMessage4 = new TextMessage();
        $textMessage4->setAccount($account);
        $textMessage4->setTouser('test_user_openid_004');
        $textMessage4->setContent('🎉 限时优惠！全场商品8折起，满199元免邮！活动截止到本月底，点击小程序查看更多详情。');

        $manager->persist($textMessage4);

        // 创建系统维护通知
        $textMessage5 = new TextMessage();
        $textMessage5->setAccount($account);
        $textMessage5->setTouser('test_user_openid_005');
        $textMessage5->setContent('系统维护通知：为了提供更好的服务体验，系统将于今晚23:00-次日02:00进行维护升级，期间可能影响部分功能使用，请您谅解。');

        $manager->persist($textMessage5);

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            AccountFixtures::class,
        ];
    }
}
