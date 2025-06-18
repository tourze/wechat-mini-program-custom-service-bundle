<?php

namespace WechatMiniProgramCustomServiceBundle\Tests\Entity;

use PHPUnit\Framework\TestCase;
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramCustomServiceBundle\Entity\AbstractMessage;

class AbstractMessageTest extends TestCase
{
    /**
     * 创建一个 AbstractMessage 的具体实现用于测试
     */
    private function createConcreteMessage(): AbstractMessage
    {
        return new class extends AbstractMessage {
            public function getMsgtype(): string
            {
                return 'test';
            }

            public function toArray(): array
            {
                return [
                    'touser' => $this->getTouser(),
                    'msgtype' => $this->getMsgtype(),
                    'test' => [],
                ];
            }
        };
    }

    public function testConstructor_shouldInitializeCreateTime(): void
    {
        $message = $this->createConcreteMessage();

        $this->assertInstanceOf(\DateTimeImmutable::class, $message->getCreateTime());
        $this->assertLessThanOrEqual(2, time() - $message->getCreateTime()->getTimestamp());
    }

    public function testGetAndSetAccount_shouldWorkCorrectly(): void
    {
        $message = $this->createConcreteMessage();
        $account = $this->createMock(Account::class);

        $this->assertNull($message->getAccount());

        $result = $message->setAccount($account);

        $this->assertSame($message, $result);
        $this->assertSame($account, $message->getAccount());
    }

    public function testGetAndSetTouser_shouldWorkCorrectly(): void
    {
        $message = $this->createConcreteMessage();
        $openId = 'oABC123456789';

        $this->assertNull($message->getTouser());

        $result = $message->setTouser($openId);

        $this->assertSame($message, $result);
        $this->assertSame($openId, $message->getTouser());
    }

    public function testGetId_shouldReturnNull_whenIdIsNotSet(): void
    {
        $message = $this->createConcreteMessage();

        $this->assertNull($message->getId());
    }
}
