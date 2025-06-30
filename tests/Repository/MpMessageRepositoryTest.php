<?php

namespace WechatMiniProgramCustomServiceBundle\Tests\Repository;

use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use WechatMiniProgramCustomServiceBundle\Entity\MpPageMessage;
use WechatMiniProgramCustomServiceBundle\Repository\MpMessageRepository;

class MpMessageRepositoryTest extends TestCase
{
    public function testConstructor(): void
    {
        $registry = $this->createMock(ManagerRegistry::class);
        
        $repository = new MpMessageRepository($registry);
        
        $this->assertInstanceOf(MpMessageRepository::class, $repository);
    }
}