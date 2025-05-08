<?php

namespace WechatMiniProgramCustomServiceBundle\Tests\EventSubscriber;

use PHPUnit\Framework\TestCase;
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramBundle\Service\Client;
use WechatMiniProgramCustomServiceBundle\Entity\TextMessage;
use WechatMiniProgramCustomServiceBundle\EventSubscriber\MessageListener;
use WechatMiniProgramCustomServiceBundle\Request\SendMessageRequest;

class MessageListenerTest extends TestCase
{
    private Client $client;
    private MessageListener $messageListener;

    protected function setUp(): void
    {
        $this->client = $this->createMock(Client::class);
        $this->messageListener = new MessageListener($this->client);
    }

    public function testPostPersist_shouldCreateRequestWithCorrectAccountAndMessage(): void
    {
        $account = $this->createMock(Account::class);
        $message = $this->createPartialMock(TextMessage::class, ['getAccount']);

        $message->expects($this->once())
            ->method('getAccount')
            ->willReturn($account);

        $this->client->expects($this->once())
            ->method('asyncRequest')
            ->with($this->callback(function ($request) use ($account, $message) {
                if (!($request instanceof SendMessageRequest)) {
                    return false;
                }

                return $request->getAccount() === $account &&
                    $request->getMessage() === $message;
            }));

        $this->messageListener->postPersist($message);
    }
}
