<?php

namespace WechatMiniProgramCustomServiceBundle\Tests\Repository;

use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use WechatMiniProgramCustomServiceBundle\Entity\LinkMessage;
use WechatMiniProgramCustomServiceBundle\Repository\LinkMessageRepository;

class LinkMessageRepositoryTest extends TestCase
{
    public function testConstructor(): void
    {
        $registry = $this->createMock(ManagerRegistry::class);
        
        $repository = new LinkMessageRepository($registry);
        
        $this->assertInstanceOf(LinkMessageRepository::class, $repository);
    }
}