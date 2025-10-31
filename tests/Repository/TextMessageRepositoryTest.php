<?php

declare(strict_types=1);

namespace WechatMiniProgramCustomServiceBundle\Tests\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractRepositoryTestCase;
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramCustomServiceBundle\Entity\TextMessage;
use WechatMiniProgramCustomServiceBundle\Repository\TextMessageRepository;

/**
 * @internal
 */
#[CoversClass(TextMessageRepository::class)]
#[RunTestsInSeparateProcesses]
final class TextMessageRepositoryTest extends AbstractRepositoryTestCase
{
    private TextMessageRepository $repository;

    protected function onSetUp(): void
    {
        $this->repository = self::getService(TextMessageRepository::class);
    }

    public function testSaveAndFindTextMessage(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id');
        $account->setAppSecret('test_app_secret');

        self::getEntityManager()->persist($account);
        self::getEntityManager()->flush();

        $textMessage = new TextMessage();
        $textMessage->setAccount($account);
        $textMessage->setTouser('test_openid');
        $textMessage->setContent('Hello, this is a test message!');

        $this->repository->save($textMessage);

        $savedMessage = $this->repository->find($textMessage->getId());
        $this->assertInstanceOf(TextMessage::class, $savedMessage);
        $this->assertSame('Hello, this is a test message!', $savedMessage->getContent());
        $this->assertSame('test_openid', $savedMessage->getTouser());
        $this->assertSame($account, $savedMessage->getAccount());
        $this->assertSame('text', $savedMessage->getMsgtype());
    }

    public function testRemoveTextMessage(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id');
        $account->setAppSecret('test_app_secret');

        self::getEntityManager()->persist($account);
        self::getEntityManager()->flush();

        $textMessage = new TextMessage();
        $textMessage->setAccount($account);
        $textMessage->setTouser('test_openid');
        $textMessage->setContent('Message to be removed');

        $this->repository->save($textMessage);
        $messageId = $textMessage->getId();

        $this->repository->remove($textMessage);

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

        $textMessage = new TextMessage();
        $textMessage->setAccount($account);
        $textMessage->setTouser('test_openid');
        $textMessage->setContent('This is a test content');

        $this->repository->save($textMessage);

        $expectedArray = [
            'touser' => 'test_openid',
            'msgtype' => 'text',
            'text' => [
                'content' => 'This is a test content',
            ],
        ];

        $this->assertSame($expectedArray, $textMessage->toArray());
    }

    public function testFindByContentPattern(): void
    {
        $account = new Account();
        $account->setName('Test Account');
        $account->setAppId('test_app_id');
        $account->setAppSecret('test_app_secret');

        self::getEntityManager()->persist($account);
        self::getEntityManager()->flush();

        $message1 = new TextMessage();
        $message1->setAccount($account);
        $message1->setTouser('user1');
        $message1->setContent('Welcome to our service');

        $message2 = new TextMessage();
        $message2->setAccount($account);
        $message2->setTouser('user2');
        $message2->setContent('Thank you for your purchase');

        $this->repository->save($message1);
        $this->repository->save($message2);

        $allMessages = $this->repository->findBy(['account' => $account]);
        $this->assertCount(2, $allMessages);

        $welcomeMessages = $this->repository->findBy(['account' => $account, 'touser' => 'user1']);
        $this->assertCount(1, $welcomeMessages);
        $firstMessage = $welcomeMessages[0];
        $this->assertInstanceOf(TextMessage::class, $firstMessage);
        $this->assertStringContainsString('Welcome', (string) $firstMessage->getContent());
    }

    protected function createNewEntity(): object
    {
        $account = new Account();
        $account->setName('Test Account ' . uniqid());
        $account->setAppId('test_app_id_' . uniqid());
        $account->setAppSecret('test_app_secret_' . uniqid());

        $entity = new TextMessage();
        $entity->setAccount($account);
        $entity->setContent('Test message content ' . uniqid());
        $entity->setTouser('test_user_' . uniqid());

        return $entity;
    }

    /**
     * @return ServiceEntityRepository<TextMessage>
     */
    protected function getRepository(): ServiceEntityRepository
    {
        return $this->repository;
    }
}
