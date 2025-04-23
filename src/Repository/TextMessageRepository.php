<?php

namespace WechatMiniProgramCustomServiceBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use WechatMiniProgramCustomServiceBundle\Entity\TextMessage;

class TextMessageRepository extends AbstractMessageRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TextMessage::class);
    }
}
