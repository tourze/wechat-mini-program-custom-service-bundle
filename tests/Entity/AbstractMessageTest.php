<?php

declare(strict_types=1);

namespace WechatMiniProgramCustomServiceBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramCustomServiceBundle\Entity\AbstractMessage;

/**
 * @internal
 */
#[CoversClass(AbstractMessage::class)]
final class AbstractMessageTest extends TestCase
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

            /**
             * @return array<string, mixed>
             */
            public function toArray(): array
            {
                return [
                    'touser' => $this->getTouser() ?? '',
                    'msgtype' => $this->getMsgtype(),
                    'test' => [],
                ];
            }
        };
    }

    public function testConstructorShouldInitializeCreateTime(): void
    {
        $message = $this->createConcreteMessage();

        $this->assertInstanceOf(\DateTimeImmutable::class, $message->getCreateTime());
        $this->assertLessThanOrEqual(2, time() - $message->getCreateTime()->getTimestamp());
    }

    public function testGetAndSetAccountShouldWorkCorrectly(): void
    {
        $message = $this->createConcreteMessage();
        // 使用 WechatMiniProgramBundle\Entity\Account 具体类进行 mock 的原因：
        // 1. AbstractMessage 中的 account 属性直接使用了 Account 具体类，而非接口
        // 2. Doctrine ORM 映射要求使用具体实体类，无法使用接口
        // 3. Account 类是外部依赖包提供的实体，我们无法修改其定义为接口
        $account = $this->createMock(Account::class);

        $this->assertNull($message->getAccount());

        $message->setAccount($account);
        $this->assertSame($account, $message->getAccount());
    }

    public function testGetAndSetTouserShouldWorkCorrectly(): void
    {
        $message = $this->createConcreteMessage();
        $openId = 'oABC123456789';

        $this->assertNull($message->getTouser());

        $message->setTouser($openId);
        $this->assertSame($openId, $message->getTouser());
    }

    public function testGetIdShouldReturnNullWhenIdIsNotSet(): void
    {
        $message = $this->createConcreteMessage();

        $this->assertNull($message->getId());
    }
}
