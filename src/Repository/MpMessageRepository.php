<?php

namespace WechatMiniProgramCustomServiceBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use WechatMiniProgramCustomServiceBundle\Entity\MpPageMessage;

class MpMessageRepository extends AbstractMessageRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MpPageMessage::class);
    }
}
