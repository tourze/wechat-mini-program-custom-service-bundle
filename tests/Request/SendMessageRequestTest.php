<?php

declare(strict_types=1);

namespace WechatMiniProgramCustomServiceBundle\Tests\Request;

use HttpClientBundle\Tests\Request\RequestTestCase;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\MockObject;
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramCustomServiceBundle\Entity\TextMessage;
use WechatMiniProgramCustomServiceBundle\Request\SendMessageRequest;

/**
 * @internal
 */
#[CoversClass(SendMessageRequest::class)]
final class SendMessageRequestTest extends RequestTestCase
{
    private SendMessageRequest $request;

    private TextMessage&MockObject $message;

    private Account&MockObject $account;

    protected function setUp(): void
    {
        parent::setUp();

        $this->request = new SendMessageRequest();
        // 使用 WechatMiniProgramCustomServiceBundle\Entity\TextMessage 具体类进行 mock 的原因：
        // 1. SendMessageRequest 依赖于具体的 Message 实体类，而非接口
        // 2. TextMessage 是本包提供的实体类，用于测试具体的消息类型
        // 3. 测试目的是验证 SendMessageRequest 的行为，而非 TextMessage 的实现
        /** @var TextMessage&MockObject $message */
        $message = $this->createMock(TextMessage::class);
        $this->message = $message;
        // 使用 WechatMiniProgramBundle\Entity\Account 具体类进行 mock 的原因：
        // 1. AbstractMessage 中的 account 属性直接使用了 Account 具体类，而非接口
        // 2. Doctrine ORM 映射要求使用具体实体类，无法使用接口
        // 3. Account 类是外部依赖包提供的实体，我们无法修改其定义为接口
        /** @var Account&MockObject $account */
        $account = $this->createMock(Account::class);
        $this->account = $account;
    }

    public function testGetRequestPathShouldReturnCorrectUrl(): void
    {
        $expected = 'https://api.weixin.qq.com/cgi-bin/message/custom/send';
        $this->assertSame($expected, $this->request->getRequestPath());
    }

    public function testGetRequestMethodShouldReturnPost(): void
    {
        $this->assertSame('POST', $this->request->getRequestMethod());
    }

    public function testGetAndSetMessageShouldWorkCorrectly(): void
    {
        $this->request->setMessage($this->message);

        $this->assertSame($this->message, $this->request->getMessage());
    }

    public function testGetRequestOptionsShouldReturnCorrectJsonOptions(): void
    {
        $messageArray = ['key' => 'value'];

        $this->message->expects(self::once())
            ->method('toArray')
            ->willReturn($messageArray)
        ;

        $this->request->setMessage($this->message);

        $options = $this->request->getRequestOptions();
        $this->assertIsArray($options);
        $this->assertArrayHasKey('json', $options);
        $this->assertSame($messageArray, $options['json']);
    }

    public function testRequestWithAccountShouldInheritAccountFromParent(): void
    {
        $this->request->setAccount($this->account);
        $this->request->setMessage($this->message);

        // 验证请求已设置账号 (间接测试父类功能)
        $this->assertSame($this->account, $this->request->getAccount());
    }
}
