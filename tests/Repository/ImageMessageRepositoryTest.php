<?php

namespace WechatMiniProgramCustomServiceBundle\Tests\Repository;

use Doctrine\Persistence\ManagerRegistry;
use PHPUnit\Framework\TestCase;
use WechatMiniProgramCustomServiceBundle\Entity\ImageMessage;
use WechatMiniProgramCustomServiceBundle\Repository\ImageMessageRepository;

class ImageMessageRepositoryTest extends TestCase
{
    public function testConstructor(): void
    {
        $registry = $this->createMock(ManagerRegistry::class);
        
        $repository = new ImageMessageRepository($registry);
        
        $this->assertInstanceOf(ImageMessageRepository::class, $repository);
    }
}