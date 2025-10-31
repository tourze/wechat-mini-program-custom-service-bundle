<?php

declare(strict_types=1);

namespace WechatMiniProgramCustomServiceBundle\Tests\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramCustomServiceBundle\Entity\MpPageMessage;
use WechatMiniProgramCustomServiceBundle\Repository\MpMessageRepository;

/**
 * @internal
 */
#[CoversClass(MpMessageRepository::class)]
#[RunTestsInSeparateProcesses]
final class MpMessageRepositoryTest extends AbstractRepositoryTestCase
{
    private MpMessageRepository $repository;

    protected function onSetUp(): void
    {
        $this->repository = self::getService(MpMessageRepository::class);
    }

    public function testSaveAndFindMpPageMessage(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id');
        $account->setAppSecret('test_app_secret');

        self::getEntityManager()->persist($account);
        self::getEntityManager()->flush();

        $mpMessage = new MpPageMessage();
        $mpMessage->setAccount($account);
        $mpMessage->setTouser('test_openid');
        $mpMessage->setTitle('Test MiniProgram Title');
        $mpMessage->setPagePath('pages/index/index');
        $mpMessage->setThumbMediaId('test_media_id');

        $this->repository->save($mpMessage);

        $savedMessage = $this->repository->find($mpMessage->getId());
        $this->assertInstanceOf(MpPageMessage::class, $savedMessage);
        $this->assertSame('Test MiniProgram Title', $savedMessage->getTitle());
        $this->assertSame('pages/index/index', $savedMessage->getPagePath());
        $this->assertSame('test_media_id', $savedMessage->getThumbMediaId());
        $this->assertSame('test_openid', $savedMessage->getTouser());
        $this->assertSame($account, $savedMessage->getAccount());
        $this->assertSame('miniprogrampage', $savedMessage->getMsgtype());
    }

    public function testRemoveMpPageMessage(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id');
        $account->setAppSecret('test_app_secret');

        self::getEntityManager()->persist($account);
        self::getEntityManager()->flush();

        $mpMessage = new MpPageMessage();
        $mpMessage->setAccount($account);
        $mpMessage->setTouser('test_openid');
        $mpMessage->setTitle('Test Title');
        $mpMessage->setPagePath('pages/test/test');
        $mpMessage->setThumbMediaId('test_media_id');

        $this->repository->save($mpMessage);
        $messageId = $mpMessage->getId();

        $this->repository->remove($mpMessage);

        $removedMessage = $this->repository->find($messageId);
        $this->assertNull($removedMessage);
    }

    public function testToArrayFormat(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id');
        $account->setAppSecret('test_app_secret');

        self::getEntityManager()->persist($account);
        self::getEntityManager()->flush();

        $mpMessage = new MpPageMessage();
        $mpMessage->setAccount($account);
        $mpMessage->setTouser('test_openid');
        $mpMessage->setTitle('Card Title');
        $mpMessage->setPagePath('pages/card/card');
        $mpMessage->setThumbMediaId('card_media_id');

        $this->repository->save($mpMessage);

        $expectedArray = [
            'touser' => 'test_openid',
            'msgtype' => 'miniprogrampage',
            'miniprogrampage' => [
                'title' => 'Card Title',
                'pagepath' => 'pages/card/card',
                'thumb_media_id' => 'card_media_id',
            ],
        ];

        $this->assertSame($expectedArray, $mpMessage->toArray());
    }

    protected function createNewEntity(): object
    {
        $account = new Account();
        $account->setName('Test Account ' . uniqid());
        $account->setAppId('test_app_id_' . uniqid());
        $account->setAppSecret('test_app_secret_' . uniqid());

        $entity = new MpPageMessage();
        $entity->setAccount($account);
        $entity->setTitle('Test Mini Program ' . uniqid());
        $entity->setPagePath('/pages/index/index');
        $entity->setThumbMediaId('test_thumb_media_id');
        $entity->setTouser('test_user_' . uniqid());

        return $entity;
    }

    /**
     * @return ServiceEntityRepository<MpPageMessage>
     */
    protected function getRepository(): ServiceEntityRepository
    {
        return $this->repository;
    }
}
