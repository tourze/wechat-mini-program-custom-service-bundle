<?php

declare(strict_types=1);

namespace WechatMiniProgramCustomServiceBundle\Tests\EventSubscriber;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramBundle\Service\Client;
use WechatMiniProgramCustomServiceBundle\Entity\TextMessage;
use WechatMiniProgramCustomServiceBundle\EventSubscriber\MessageListener;
use WechatMiniProgramCustomServiceBundle\Request\SendMessageRequest;

/**
 * MessageListener 测试类
 *
 * 这个测试验证 MessageListener 的事件处理逻辑
 *
 * @internal
 */
#[CoversClass(MessageListener::class)]
final class MessageListenerTest extends TestCase
{
    private Client&MockObject $client;

    private MessageListener $messageListener;

    protected function setUp(): void
    {
        parent::setUp();

        // 创建 mock 依赖，在集成测试中模拟外部服务
        // 这种方式符合集成测试最佳实践：测试组件间的交互，而非外部依赖的实现
        /** @var Client&MockObject $client */
        $client = $this->createMock(Client::class);
        $this->client = $client;

        // 直接实例化 MessageListener 并注入 mock 依赖
        // 这样既满足了集成测试的需求，又避免了容器服务替换的问题
        // 由于 MessageListener 是 Doctrine EntityListener，直接从容器获取会导致
        // "service is already initialized" 错误，因此我们直接实例化它
        // @phpstan-ignore integrationTest.noDirectInstantiationOfCoveredClass
        $this->messageListener = new MessageListener($this->client);
    }

    public function testPostPersistShouldCreateRequestWithCorrectAccountAndMessage(): void
    {
        // 使用 WechatMiniProgramBundle\Entity\Account 具体类进行 mock 的原因：
        // 1. AbstractMessage 中的 account 属性直接使用了 Account 具体类，而非接口
        // 2. Doctrine ORM 映射要求使用具体实体类，无法使用接口
        // 3. Account 类是外部依赖包提供的实体，我们无法修改其定义为接口
        $account = $this->createMock(Account::class);

        // 使用 WechatMiniProgramCustomServiceBundle\Entity\TextMessage 具体类进行 mock 的原因：
        // 1. MessageListener 直接依赖 AbstractMessage 及其子类，而非接口
        // 2. TextMessage 是消息实体类，需要测试其与 MessageListener 的交互
        // 3. 使用 createPartialMock 以便保留其他方法的原始实现，只模拟必要的 getAccount 方法
        /** @var TextMessage&MockObject $message */
        $message = $this->createPartialMock(TextMessage::class, ['getAccount']);

        $message->expects(self::once())
            ->method('getAccount')
            ->willReturn($account)
        ;

        $this->client->expects(self::once())
            ->method('asyncRequest')
            ->with(self::callback(function ($request) use ($account, $message) {
                if (!($request instanceof SendMessageRequest)) {
                    return false;
                }

                return $request->getAccount() === $account
                    && $request->getMessage() === $message;
            }))
        ;

        $this->messageListener->postPersist($message);
    }
}
