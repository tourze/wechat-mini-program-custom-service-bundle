<?php

namespace WechatMiniProgramCustomServiceBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Tourze\PHPUnitSymfonyKernelTest\Attribute\AsRepository;
use WechatMiniProgramCustomServiceBundle\Entity\MpPageMessage;

/**
 * @extends ServiceEntityRepository<MpPageMessage>
 */
#[AsRepository(entityClass: MpPageMessage::class)]
class MpMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MpPageMessage::class);
    }

    public function save(MpPageMessage $entity, bool $flush = true): void
    {
        $this->getEntityManager()->persist($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MpPageMessage $entity, bool $flush = true): void
    {
        $this->getEntityManager()->remove($entity);
        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
