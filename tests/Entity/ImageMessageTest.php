<?php

declare(strict_types=1);

namespace WechatMiniProgramCustomServiceBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramCustomServiceBundle\Entity\ImageMessage;

/**
 * @internal
 */
#[CoversClass(ImageMessage::class)]
final class ImageMessageTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new ImageMessage();
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function propertiesProvider(): iterable
    {
        yield 'mediaId' => ['mediaId', 'MEDIA_ID_123456'];
    }

    public function testGetAndSetMediaIdShouldWorkCorrectly(): void
    {
        $imageMessage = new ImageMessage();
        $mediaId = 'MEDIA_ID_12345';

        $this->assertNull($imageMessage->getMediaId());

        $imageMessage->setMediaId($mediaId);
        $this->assertSame($mediaId, $imageMessage->getMediaId());
    }

    public function testGetMsgtypeShouldReturnImage(): void
    {
        $imageMessage = new ImageMessage();

        $this->assertSame('image', $imageMessage->getMsgtype());
    }

    public function testToArrayShouldReturnFormattedArray(): void
    {
        $imageMessage = new ImageMessage();
        // 使用 WechatMiniProgramBundle\Entity\Account 具体类进行 mock 的原因：
        // 1. AbstractMessage 中的 account 属性直接使用了 Account 具体类，而非接口
        // 2. Doctrine ORM 映射要求使用具体实体类，无法使用接口
        // 3. Account 类是外部依赖包提供的实体，我们无法修改其定义为接口
        $account = $this->createMock(Account::class);
        $openId = 'oABC123456789';
        $mediaId = 'MEDIA_ID_12345';

        $imageMessage->setAccount($account);
        $imageMessage->setTouser($openId);
        $imageMessage->setMediaId($mediaId);

        $expected = [
            'touser' => $openId,
            'msgtype' => 'image',
            'image' => [
                'media_id' => $mediaId,
            ],
        ];

        $this->assertEquals($expected, $imageMessage->toArray());
    }

    public function testToArrayWithInvalidMediaIdShouldReturnArrayWithEmptyMediaId(): void
    {
        $imageMessage = new ImageMessage();
        // 使用 WechatMiniProgramBundle\Entity\Account 具体类进行 mock 的原因：
        // 1. AbstractMessage 中的 account 属性直接使用了 Account 具体类，而非接口
        // 2. Doctrine ORM 映射要求使用具体实体类，无法使用接口
        // 3. Account 类是外部依赖包提供的实体，我们无法修改其定义为接口
        $account = $this->createMock(Account::class);
        $openId = 'oABC123456789';
        $emptyMediaId = '';

        $imageMessage->setAccount($account);
        $imageMessage->setTouser($openId);
        $imageMessage->setMediaId($emptyMediaId);

        $result = $imageMessage->toArray();

        $this->assertSame($openId, $result['touser']);
        $this->assertSame('image', $result['msgtype']);
        $this->assertArrayHasKey('image', $result);
        $this->assertArrayHasKey('media_id', $result['image']);
        $this->assertSame($emptyMediaId, $result['image']['media_id']);
    }

    public function testToArrayWithLongMediaIdShouldNotTruncateMediaId(): void
    {
        $imageMessage = new ImageMessage();
        // 使用 WechatMiniProgramBundle\Entity\Account 具体类进行 mock 的原因：
        // 1. AbstractMessage 中的 account 属性直接使用了 Account 具体类，而非接口
        // 2. Doctrine ORM 映射要求使用具体实体类，无法使用接口
        // 3. Account 类是外部依赖包提供的实体，我们无法修改其定义为接口
        $account = $this->createMock(Account::class);
        $openId = 'oABC123456789';
        $longMediaId = str_repeat('a', 200); // 创建一个长的媒体ID

        $imageMessage->setAccount($account);
        $imageMessage->setTouser($openId);
        $imageMessage->setMediaId($longMediaId);

        $result = $imageMessage->toArray();

        $this->assertSame($longMediaId, $result['image']['media_id']);
    }
}
