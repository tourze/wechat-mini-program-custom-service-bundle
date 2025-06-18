<?php

namespace WechatMiniProgramCustomServiceBundle\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use WechatMiniProgramCustomServiceBundle\Entity\AbstractMessage;

abstract class AbstractMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, string $entityClass)
    {
        parent::__construct($registry, $entityClass);
    }

    public function save(AbstractMessage $message, bool $flush = false): void
    {
        $this->getEntityManager()->persist($message);

        if ((bool) $flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AbstractMessage $message, bool $flush = false): void
    {
        $this->getEntityManager()->remove($message);

        if ((bool) $flush) {
            $this->getEntityManager()->flush();
        }
    }
}
