<?php

namespace WechatMiniProgramCustomServiceBundle\Tests\Request;

use PHPUnit\Framework\TestCase;
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramCustomServiceBundle\Entity\TextMessage;
use WechatMiniProgramCustomServiceBundle\Request\SendMessageRequest;

class SendMessageRequestTest extends TestCase
{
    private SendMessageRequest $request;
    private TextMessage $message;
    private Account $account;

    protected function setUp(): void
    {
        $this->request = new SendMessageRequest();
        $this->message = $this->createMock(TextMessage::class);
        $this->account = $this->createMock(Account::class);
    }

    public function testGetRequestPath_shouldReturnCorrectUrl(): void
    {
        $expected = 'https://api.weixin.qq.com/cgi-bin/message/custom/send';
        $this->assertSame($expected, $this->request->getRequestPath());
    }

    public function testGetRequestMethod_shouldReturnPost(): void
    {
        $this->assertSame('POST', $this->request->getRequestMethod());
    }

    public function testGetAndSetMessage_shouldWorkCorrectly(): void
    {
        $this->request->setMessage($this->message);

        $this->assertSame($this->message, $this->request->getMessage());
    }

    public function testGetRequestOptions_shouldReturnCorrectJsonOptions(): void
    {
        $messageArray = ['key' => 'value'];

        $this->message->expects($this->once())
            ->method('toArray')
            ->willReturn($messageArray);

        $this->request->setMessage($this->message);

        $options = $this->request->getRequestOptions();
        $this->assertArrayHasKey('json', $options);
        $this->assertSame($messageArray, $options['json']);
    }

    public function testRequestWithAccount_shouldInheritAccountFromParent(): void
    {
        $this->request->setAccount($this->account);
        $this->request->setMessage($this->message);

        // 验证请求已设置账号 (间接测试父类功能)
        $this->assertSame($this->account, $this->request->getAccount());
    }
}
