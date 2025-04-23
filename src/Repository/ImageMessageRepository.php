<?php

namespace WechatMiniProgramCustomServiceBundle\Repository;

use Doctrine\Persistence\ManagerRegistry;
use WechatMiniProgramCustomServiceBundle\Entity\ImageMessage;

class ImageMessageRepository extends AbstractMessageRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageMessage::class);
    }
}
