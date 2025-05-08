<?php

namespace WechatMiniProgramCustomServiceBundle\Tests\Entity;

use PHPUnit\Framework\TestCase;
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramCustomServiceBundle\Entity\ImageMessage;

class ImageMessageTest extends TestCase
{
    public function testGetAndSetMediaId_shouldWorkCorrectly(): void
    {
        $imageMessage = new ImageMessage();
        $mediaId = 'MEDIA_ID_12345';

        $this->assertNull($imageMessage->getMediaId());

        $result = $imageMessage->setMediaId($mediaId);

        $this->assertSame($imageMessage, $result);
        $this->assertSame($mediaId, $imageMessage->getMediaId());
    }

    public function testGetMsgtype_shouldReturnImage(): void
    {
        $imageMessage = new ImageMessage();

        $this->assertSame('image', $imageMessage->getMsgtype());
    }

    public function testToArray_shouldReturnFormattedArray(): void
    {
        $imageMessage = new ImageMessage();
        $account = $this->createMock(Account::class);
        $openId = 'oABC123456789';
        $mediaId = 'MEDIA_ID_12345';

        $imageMessage
            ->setAccount($account)
            ->setTouser($openId)
            ->setMediaId($mediaId);

        $expected = [
            'touser' => $openId,
            'msgtype' => 'image',
            'image' => [
                'media_id' => $mediaId,
            ],
        ];

        $this->assertEquals($expected, $imageMessage->toArray());
    }

    public function testToArray_withInvalidMediaId_shouldReturnArrayWithEmptyMediaId(): void
    {
        $imageMessage = new ImageMessage();
        $account = $this->createMock(Account::class);
        $openId = 'oABC123456789';
        $emptyMediaId = '';

        $imageMessage
            ->setAccount($account)
            ->setTouser($openId)
            ->setMediaId($emptyMediaId);

        $result = $imageMessage->toArray();

        $this->assertSame($openId, $result['touser']);
        $this->assertSame('image', $result['msgtype']);
        $this->assertArrayHasKey('image', $result);
        $this->assertArrayHasKey('media_id', $result['image']);
        $this->assertSame($emptyMediaId, $result['image']['media_id']);
    }

    public function testToArray_withLongMediaId_shouldNotTruncateMediaId(): void
    {
        $imageMessage = new ImageMessage();
        $account = $this->createMock(Account::class);
        $openId = 'oABC123456789';
        $longMediaId = str_repeat('a', 200); // 创建一个长的媒体ID

        $imageMessage
            ->setAccount($account)
            ->setTouser($openId)
            ->setMediaId($longMediaId);

        $result = $imageMessage->toArray();

        $this->assertSame($longMediaId, $result['image']['media_id']);
    }
}
