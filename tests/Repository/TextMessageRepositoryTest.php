<?php

namespace WechatMiniProgramCustomServiceBundle\Tests\Repository;

use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use WechatMiniProgramCustomServiceBundle\Entity\TextMessage;
use WechatMiniProgramCustomServiceBundle\Repository\TextMessageRepository;

class TextMessageRepositoryTest extends TestCase
{
    public function testConstructor(): void
    {
        $registry = $this->createMock(ManagerRegistry::class);
        
        $repository = new TextMessageRepository($registry);
        
        $this->assertInstanceOf(TextMessageRepository::class, $repository);
    }
}