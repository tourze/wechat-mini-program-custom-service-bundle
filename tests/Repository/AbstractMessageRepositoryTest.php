<?php

namespace WechatMiniProgramCustomServiceBundle\Tests\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use WechatMiniProgramCustomServiceBundle\Entity\TextMessage;
use WechatMiniProgramCustomServiceBundle\Repository\TextMessageRepository;

class AbstractMessageRepositoryTest extends TestCase
{
    public function testSave_shouldPersistEntity(): void
    {
        // 模拟依赖
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $registry = $this->createMock(ManagerRegistry::class);
        $message = $this->createMock(TextMessage::class);

        // 创建一个具体的 repository 子类进行测试
        $repository = $this->getMockBuilder(TextMessageRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getEntityManager'])
            ->getMock();

        // 设置 getEntityManager 的返回值，允许被调用任意次数
        $repository->expects($this->any())
            ->method('getEntityManager')
            ->willReturn($entityManager);

        // 验证 persist 方法被调用
        $entityManager->expects($this->once())
            ->method('persist')
            ->with($message);

        // 验证 flush 方法未被调用
        $entityManager->expects($this->never())
            ->method('flush');

        // 调用测试方法
        $repository->save($message);
    }

    public function testSave_withFlushTrue_shouldPersistAndFlushEntity(): void
    {
        // 模拟依赖
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $registry = $this->createMock(ManagerRegistry::class);
        $message = $this->createMock(TextMessage::class);

        // 创建一个具体的 repository 子类进行测试
        $repository = $this->getMockBuilder(TextMessageRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getEntityManager'])
            ->getMock();

        // 设置 getEntityManager 的返回值，允许被调用任意次数
        $repository->expects($this->any())
            ->method('getEntityManager')
            ->willReturn($entityManager);

        // 验证 persist 方法被调用
        $entityManager->expects($this->once())
            ->method('persist')
            ->with($message);

        // 验证 flush 方法被调用
        $entityManager->expects($this->once())
            ->method('flush');

        // 调用测试方法
        $repository->save($message, true);
    }

    public function testRemove_shouldRemoveEntity(): void
    {
        // 模拟依赖
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $registry = $this->createMock(ManagerRegistry::class);
        $message = $this->createMock(TextMessage::class);

        // 创建一个具体的 repository 子类进行测试
        $repository = $this->getMockBuilder(TextMessageRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getEntityManager'])
            ->getMock();

        // 设置 getEntityManager 的返回值，允许被调用任意次数
        $repository->expects($this->any())
            ->method('getEntityManager')
            ->willReturn($entityManager);

        // 验证 remove 方法被调用
        $entityManager->expects($this->once())
            ->method('remove')
            ->with($message);

        // 验证 flush 方法未被调用
        $entityManager->expects($this->never())
            ->method('flush');

        // 调用测试方法
        $repository->remove($message);
    }

    public function testRemove_withFlushTrue_shouldRemoveAndFlushEntity(): void
    {
        // 模拟依赖
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $registry = $this->createMock(ManagerRegistry::class);
        $message = $this->createMock(TextMessage::class);

        // 创建一个具体的 repository 子类进行测试
        $repository = $this->getMockBuilder(TextMessageRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getEntityManager'])
            ->getMock();

        // 设置 getEntityManager 的返回值，允许被调用任意次数
        $repository->expects($this->any())
            ->method('getEntityManager')
            ->willReturn($entityManager);

        // 验证 remove 方法被调用
        $entityManager->expects($this->once())
            ->method('remove')
            ->with($message);

        // 验证 flush 方法被调用
        $entityManager->expects($this->once())
            ->method('flush');

        // 调用测试方法
        $repository->remove($message, true);
    }
}
