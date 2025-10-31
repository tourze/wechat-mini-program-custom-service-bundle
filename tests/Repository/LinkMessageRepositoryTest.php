<?php

declare(strict_types=1);

namespace WechatMiniProgramCustomServiceBundle\Tests\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramCustomServiceBundle\Entity\LinkMessage;
use WechatMiniProgramCustomServiceBundle\Repository\LinkMessageRepository;

/**
 * @internal
 */
#[CoversClass(LinkMessageRepository::class)]
#[RunTestsInSeparateProcesses]
final class LinkMessageRepositoryTest extends AbstractRepositoryTestCase
{
    private LinkMessageRepository $repository;

    protected function onSetUp(): void
    {
        $this->repository = self::getService(LinkMessageRepository::class);
    }

    public function testSaveAndFindLinkMessage(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id');
        $account->setAppSecret('test_app_secret');

        self::getEntityManager()->persist($account);
        self::getEntityManager()->flush();

        $linkMessage = new LinkMessage();
        $linkMessage->setAccount($account);
        $linkMessage->setTouser('test_openid');
        $linkMessage->setTitle('Test Title');
        $linkMessage->setDescription('Test Description');
        $linkMessage->setUrl('https://example.com');
        $linkMessage->setThumbUrl('https://example.com/thumb.jpg');

        $this->repository->save($linkMessage);

        $savedMessage = $this->repository->find($linkMessage->getId());
        $this->assertInstanceOf(LinkMessage::class, $savedMessage);
        $this->assertSame('Test Title', $savedMessage->getTitle());
        $this->assertSame('Test Description', $savedMessage->getDescription());
        $this->assertSame('https://example.com', $savedMessage->getUrl());
        $this->assertSame('https://example.com/thumb.jpg', $savedMessage->getThumbUrl());
        $this->assertSame('test_openid', $savedMessage->getTouser());
        $this->assertSame($account, $savedMessage->getAccount());
    }

    public function testRemoveLinkMessage(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id');
        $account->setAppSecret('test_app_secret');

        self::getEntityManager()->persist($account);
        self::getEntityManager()->flush();

        $linkMessage = new LinkMessage();
        $linkMessage->setAccount($account);
        $linkMessage->setTouser('test_openid');
        $linkMessage->setTitle('Test Title');
        $linkMessage->setDescription('Test Description');
        $linkMessage->setUrl('https://example.com');

        $this->repository->save($linkMessage);
        $messageId = $linkMessage->getId();

        $this->repository->remove($linkMessage);

        $removedMessage = $this->repository->find($messageId);
        $this->assertNull($removedMessage);
    }

    public function testFindByAccount(): void
    {
        $account1 = new Account();
        $account1->setName('Test Account 1');
        $account1->setAppId('test_app_id_1');
        $account1->setAppSecret('test_app_secret_1');

        $account2 = new Account();
        $account2->setName('Test Account 2');
        $account2->setAppId('test_app_id_2');
        $account2->setAppSecret('test_app_secret_2');

        self::getEntityManager()->persist($account1);
        self::getEntityManager()->persist($account2);
        self::getEntityManager()->flush();

        $message1 = new LinkMessage();
        $message1->setAccount($account1);
        $message1->setTouser('user1');
        $message1->setTitle('Title 1');
        $message1->setDescription('Description 1');
        $message1->setUrl('https://example1.com');

        $message2 = new LinkMessage();
        $message2->setAccount($account2);
        $message2->setTouser('user2');
        $message2->setTitle('Title 2');
        $message2->setDescription('Description 2');
        $message2->setUrl('https://example2.com');

        $this->repository->save($message1);
        $this->repository->save($message2);

        $messagesForAccount1 = $this->repository->findBy(['account' => $account1]);
        $this->assertCount(1, $messagesForAccount1);
        $firstMessage1 = $messagesForAccount1[0];
        $this->assertInstanceOf(LinkMessage::class, $firstMessage1);
        $this->assertSame('Title 1', $firstMessage1->getTitle());

        $messagesForAccount2 = $this->repository->findBy(['account' => $account2]);
        $this->assertCount(1, $messagesForAccount2);
        $firstMessage2 = $messagesForAccount2[0];
        $this->assertInstanceOf(LinkMessage::class, $firstMessage2);
        $this->assertSame('Title 2', $firstMessage2->getTitle());
    }

    protected function createNewEntity(): object
    {
        $account = new Account();
        $account->setName('Test Account ' . uniqid());
        $account->setAppId('test_app_id_' . uniqid());
        $account->setAppSecret('test_app_secret_' . uniqid());

        $entity = new LinkMessage();
        $entity->setAccount($account);
        $entity->setTitle('Test Title ' . uniqid());
        $entity->setDescription('Test Description');
        $entity->setUrl('https://example.com');
        $entity->setThumbUrl('https://example.com/thumb.jpg');
        $entity->setTouser('test_user_' . uniqid());

        return $entity;
    }

    /**
     * @return ServiceEntityRepository<LinkMessage>
     */
    protected function getRepository(): ServiceEntityRepository
    {
        return $this->repository;
    }
}
