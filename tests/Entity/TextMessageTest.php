<?php

namespace WechatMiniProgramCustomServiceBundle\Tests\Entity;

use PHPUnit\Framework\TestCase;
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramCustomServiceBundle\Entity\TextMessage;

class TextMessageTest extends TestCase
{
    public function testGetAndSetContent_shouldWorkCorrectly(): void
    {
        $textMessage = new TextMessage();
        $content = '这是一条测试消息';

        $this->assertNull($textMessage->getContent());

        $result = $textMessage->setContent($content);

        $this->assertSame($textMessage, $result);
        $this->assertSame($content, $textMessage->getContent());
    }

    public function testGetMsgtype_shouldReturnText(): void
    {
        $textMessage = new TextMessage();

        $this->assertSame('text', $textMessage->getMsgtype());
    }

    public function testToArray_shouldReturnFormattedArray(): void
    {
        $textMessage = new TextMessage();
        $account = $this->createMock(Account::class);
        $openId = 'oABC123456789';
        $content = '这是一条测试消息';

        $textMessage
            ->setAccount($account)
            ->setTouser($openId)
            ->setContent($content);

        $expected = [
            'touser' => $openId,
            'msgtype' => 'text',
            'text' => [
                'content' => $content,
            ],
        ];

        $this->assertEquals($expected, $textMessage->toArray());
    }

    public function testToArray_withEmptyContent_shouldReturnArrayWithEmptyContent(): void
    {
        $textMessage = new TextMessage();
        $account = $this->createMock(Account::class);
        $openId = 'oABC123456789';
        $emptyContent = '';

        $textMessage
            ->setAccount($account)
            ->setTouser($openId)
            ->setContent($emptyContent);

        $result = $textMessage->toArray();

        $this->assertSame($openId, $result['touser']);
        $this->assertSame('text', $result['msgtype']);
        $this->assertArrayHasKey('text', $result);
        $this->assertArrayHasKey('content', $result['text']);
        $this->assertSame($emptyContent, $result['text']['content']);
    }

    public function testToArray_withLongContent_shouldNotTruncateContent(): void
    {
        $textMessage = new TextMessage();
        $account = $this->createMock(Account::class);
        $openId = 'oABC123456789';
        $longContent = str_repeat('测试消息', 100); // 创建一个长内容，但不超过2048字节

        $textMessage
            ->setAccount($account)
            ->setTouser($openId)
            ->setContent($longContent);

        $result = $textMessage->toArray();

        $this->assertSame($longContent, $result['text']['content']);
    }
}
