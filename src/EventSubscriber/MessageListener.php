<?php

namespace WechatMiniProgramCustomServiceBundle\EventSubscriber;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Doctrine\ORM\Events;
use WechatMiniProgramBundle\Service\Client;
use WechatMiniProgramCustomServiceBundle\Entity\AbstractMessage;
use WechatMiniProgramCustomServiceBundle\Entity\ImageMessage;
use WechatMiniProgramCustomServiceBundle\Entity\LinkMessage;
use WechatMiniProgramCustomServiceBundle\Entity\MpPageMessage;
use WechatMiniProgramCustomServiceBundle\Entity\TextMessage;
use WechatMiniProgramCustomServiceBundle\Request\SendMessageRequest;

#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: TextMessage::class)]
#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: ImageMessage::class)]
#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: LinkMessage::class)]
#[AsEntityListener(event: Events::postPersist, method: 'postPersist', entity: MpPageMessage::class)]
class MessageListener
{
    public function __construct(private readonly Client $client)
    {
    }

    public function postPersist(AbstractMessage $message): void
    {
        $request = new SendMessageRequest();
        $request->setAccount($message->getAccount());
        $request->setMessage($message);

        $this->client->asyncRequest($request);
    }
}
