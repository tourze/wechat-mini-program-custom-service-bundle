<?php

declare(strict_types=1);

namespace WechatMiniProgramCustomServiceBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramCustomServiceBundle\Entity\TextMessage;

/**
 * @internal
 */
#[CoversClass(TextMessage::class)]
final class TextMessageTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new TextMessage();
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function propertiesProvider(): iterable
    {
        yield 'content' => ['content', '这是一条测试消息内容'];
    }

    public function testGetAndSetContentShouldWorkCorrectly(): void
    {
        $textMessage = new TextMessage();
        $content = '这是一条测试消息';

        $this->assertNull($textMessage->getContent());

        $textMessage->setContent($content);
        $this->assertSame($content, $textMessage->getContent());
    }

    public function testGetMsgtypeShouldReturnText(): void
    {
        $textMessage = new TextMessage();

        $this->assertSame('text', $textMessage->getMsgtype());
    }

    public function testToArrayShouldReturnFormattedArray(): void
    {
        $textMessage = new TextMessage();
        // 使用 WechatMiniProgramBundle\Entity\Account 具体类进行 mock 的原因：
        // 1. AbstractMessage 中的 account 属性直接使用了 Account 具体类，而非接口
        // 2. Doctrine ORM 映射要求使用具体实体类，无法使用接口
        // 3. Account 类是外部依赖包提供的实体，我们无法修改其定义为接口
        $account = $this->createMock(Account::class);
        $openId = 'oABC123456789';
        $content = '这是一条测试消息';

        $textMessage->setAccount($account);
        $textMessage->setTouser($openId);
        $textMessage->setContent($content);

        $expected = [
            'touser' => $openId,
            'msgtype' => 'text',
            'text' => [
                'content' => $content,
            ],
        ];

        $this->assertEquals($expected, $textMessage->toArray());
    }

    public function testToArrayWithEmptyContentShouldReturnArrayWithEmptyContent(): void
    {
        $textMessage = new TextMessage();
        // 使用 WechatMiniProgramBundle\Entity\Account 具体类进行 mock 的原因：
        // 1. AbstractMessage 中的 account 属性直接使用了 Account 具体类，而非接口
        // 2. Doctrine ORM 映射要求使用具体实体类，无法使用接口
        // 3. Account 类是外部依赖包提供的实体，我们无法修改其定义为接口
        $account = $this->createMock(Account::class);
        $openId = 'oABC123456789';
        $emptyContent = '';

        $textMessage->setAccount($account);
        $textMessage->setTouser($openId);
        $textMessage->setContent($emptyContent);

        $result = $textMessage->toArray();

        $this->assertSame($openId, $result['touser']);
        $this->assertSame('text', $result['msgtype']);
        $this->assertArrayHasKey('text', $result);
        $this->assertArrayHasKey('content', $result['text']);
        $this->assertSame($emptyContent, $result['text']['content']);
    }

    public function testToArrayWithLongContentShouldNotTruncateContent(): void
    {
        $textMessage = new TextMessage();
        // 使用 WechatMiniProgramBundle\Entity\Account 具体类进行 mock 的原因：
        // 1. AbstractMessage 中的 account 属性直接使用了 Account 具体类，而非接口
        // 2. Doctrine ORM 映射要求使用具体实体类，无法使用接口
        // 3. Account 类是外部依赖包提供的实体，我们无法修改其定义为接口
        $account = $this->createMock(Account::class);
        $openId = 'oABC123456789';
        $longContent = str_repeat('测试消息', 100); // 创建一个长内容，但不超过2048字节

        $textMessage->setAccount($account);
        $textMessage->setTouser($openId);
        $textMessage->setContent($longContent);

        $result = $textMessage->toArray();

        $this->assertSame($longContent, $result['text']['content']);
    }
}
