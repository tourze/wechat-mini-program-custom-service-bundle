<?php

declare(strict_types=1);

namespace WechatMiniProgramCustomServiceBundle\Tests\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramCustomServiceBundle\Entity\ImageMessage;
use WechatMiniProgramCustomServiceBundle\Repository\ImageMessageRepository;

/**
 * @internal
 */
#[CoversClass(ImageMessageRepository::class)]
#[RunTestsInSeparateProcesses]
final class ImageMessageRepositoryTest extends AbstractRepositoryTestCase
{
    private ImageMessageRepository $repository;

    protected function onSetUp(): void
    {
        $this->repository = self::getService(ImageMessageRepository::class);
    }

    public function testSaveAndFindImageMessage(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id');
        $account->setAppSecret('test_app_secret');

        self::getEntityManager()->persist($account);
        self::getEntityManager()->flush();

        $imageMessage = new ImageMessage();
        $imageMessage->setAccount($account);
        $imageMessage->setTouser('test_openid');
        $imageMessage->setMediaId('test_media_id_12345');

        $this->repository->save($imageMessage);

        $savedMessage = $this->repository->find($imageMessage->getId());
        $this->assertInstanceOf(ImageMessage::class, $savedMessage);
        $this->assertSame('test_media_id_12345', $savedMessage->getMediaId());
        $this->assertSame('test_openid', $savedMessage->getTouser());
        $this->assertSame($account, $savedMessage->getAccount());
        $this->assertSame('image', $savedMessage->getMsgtype());
    }

    public function testRemoveImageMessage(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id');
        $account->setAppSecret('test_app_secret');

        self::getEntityManager()->persist($account);
        self::getEntityManager()->flush();

        $imageMessage = new ImageMessage();
        $imageMessage->setAccount($account);
        $imageMessage->setTouser('test_openid');
        $imageMessage->setMediaId('test_remove_media_id');

        $this->repository->save($imageMessage);
        $messageId = $imageMessage->getId();

        $this->repository->remove($imageMessage);

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

        $imageMessage = new ImageMessage();
        $imageMessage->setAccount($account);
        $imageMessage->setTouser('test_openid');
        $imageMessage->setMediaId('image_media_id_123');

        $this->repository->save($imageMessage);

        $expectedArray = [
            'touser' => 'test_openid',
            'msgtype' => 'image',
            'image' => [
                'media_id' => 'image_media_id_123',
            ],
        ];

        $this->assertSame($expectedArray, $imageMessage->toArray());
    }

    public function testFindByMediaId(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id');
        $account->setAppSecret('test_app_secret');

        self::getEntityManager()->persist($account);
        self::getEntityManager()->flush();

        $image1 = new ImageMessage();
        $image1->setAccount($account);
        $image1->setTouser('user1');
        $image1->setMediaId('media_id_001');

        $image2 = new ImageMessage();
        $image2->setAccount($account);
        $image2->setTouser('user2');
        $image2->setMediaId('media_id_002');

        $this->repository->save($image1);
        $this->repository->save($image2);

        $foundByMediaId = $this->repository->findBy(['mediaId' => 'media_id_001']);
        $this->assertCount(1, $foundByMediaId);
        $firstMessage = $foundByMediaId[0];
        $this->assertInstanceOf(ImageMessage::class, $firstMessage);
        $this->assertSame('user1', $firstMessage->getTouser());

        $allImages = $this->repository->findBy(['account' => $account]);
        $this->assertCount(2, $allImages);
    }

    protected function createNewEntity(): object
    {
        $account = new Account();
        $account->setName('Test Account ' . uniqid());
        $account->setAppId('test_app_id_' . uniqid());
        $account->setAppSecret('test_app_secret_' . uniqid());

        $entity = new ImageMessage();
        $entity->setAccount($account);
        $entity->setMediaId('test_media_id_' . uniqid());
        $entity->setTouser('test_user_' . uniqid());

        return $entity;
    }

    /**
     * @return ServiceEntityRepository<ImageMessage>
     */
    protected function getRepository(): ServiceEntityRepository
    {
        return $this->repository;
    }
}
