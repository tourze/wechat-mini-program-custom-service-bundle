<?php

namespace WechatMiniProgramCustomServiceBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use WechatMiniProgramCustomServiceBundle\Entity\LinkMessage;

class LinkMessageRepository extends AbstractMessageRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LinkMessage::class);
    }
}
