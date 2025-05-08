<?php

namespace WechatMiniProgramCustomServiceBundle\Tests\Entity;

use PHPUnit\Framework\TestCase;
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramCustomServiceBundle\Entity\MpPageMessage;

class MpPageMessageTest extends TestCase
{
    private MpPageMessage $mpPageMessage;
    private Account $account;

    protected function setUp(): void
    {
        $this->mpPageMessage = new MpPageMessage();
        $this->account = $this->createMock(Account::class);
    }

    public function testGetAndSetTitle_shouldWorkCorrectly(): void
    {
        $title = '小程序标题';

        $this->assertNull($this->mpPageMessage->getTitle());

        $result = $this->mpPageMessage->setTitle($title);

        $this->assertSame($this->mpPageMessage, $result);
        $this->assertSame($title, $this->mpPageMessage->getTitle());
    }

    public function testGetAndSetPagePath_shouldWorkCorrectly(): void
    {
        $pagePath = 'pages/index/index?param=value';

        $this->assertNull($this->mpPageMessage->getPagePath());

        $result = $this->mpPageMessage->setPagePath($pagePath);

        $this->assertSame($this->mpPageMessage, $result);
        $this->assertSame($pagePath, $this->mpPageMessage->getPagePath());
    }

    public function testGetAndSetThumbMediaId_shouldWorkCorrectly(): void
    {
        $thumbMediaId = 'MEDIA_ID_12345';

        $this->assertNull($this->mpPageMessage->getThumbMediaId());

        $result = $this->mpPageMessage->setThumbMediaId($thumbMediaId);

        $this->assertSame($this->mpPageMessage, $result);
        $this->assertSame($thumbMediaId, $this->mpPageMessage->getThumbMediaId());
    }

    public function testGetMsgtype_shouldReturnMiniprogrampage(): void
    {
        $this->assertSame('miniprogrampage', $this->mpPageMessage->getMsgtype());
    }

    public function testToArray_withAllPropertiesSet_shouldReturnCompleteArray(): void
    {
        $openId = 'oABC123456789';
        $title = '小程序标题';
        $pagePath = 'pages/index/index?param=value';
        $thumbMediaId = 'MEDIA_ID_12345';

        $this->mpPageMessage
            ->setAccount($this->account)
            ->setTouser($openId)
            ->setTitle($title)
            ->setPagePath($pagePath)
            ->setThumbMediaId($thumbMediaId);

        $expected = [
            'touser' => $openId,
            'msgtype' => 'miniprogrampage',
            'miniprogrampage' => [
                'title' => $title,
                'pagepath' => $pagePath,
                'thumb_media_id' => $thumbMediaId,
            ],
        ];

        $this->assertEquals($expected, $this->mpPageMessage->toArray());
    }

    public function testToArray_withEmptyTitle_shouldReturnArrayWithEmptyTitle(): void
    {
        $openId = 'oABC123456789';
        $emptyTitle = '';
        $pagePath = 'pages/index/index';
        $thumbMediaId = 'MEDIA_ID_12345';

        $this->mpPageMessage
            ->setAccount($this->account)
            ->setTouser($openId)
            ->setTitle($emptyTitle)
            ->setPagePath($pagePath)
            ->setThumbMediaId($thumbMediaId);

        $result = $this->mpPageMessage->toArray();

        $this->assertSame($emptyTitle, $result['miniprogrampage']['title']);
    }

    public function testToArray_withLongPathIncludingParams_shouldReturnArrayWithFullPath(): void
    {
        $openId = 'oABC123456789';
        $title = '小程序标题';
        $longPagePath = 'pages/detail/detail?id=12345&ref=share&user=test&from=timeline&scene=12345';
        $thumbMediaId = 'MEDIA_ID_12345';

        $this->mpPageMessage
            ->setAccount($this->account)
            ->setTouser($openId)
            ->setTitle($title)
            ->setPagePath($longPagePath)
            ->setThumbMediaId($thumbMediaId);

        $result = $this->mpPageMessage->toArray();

        $this->assertSame($longPagePath, $result['miniprogrampage']['pagepath']);
    }

    public function testToArray_withComplexThumbMediaId_shouldReturnArrayWithCorrectThumbMediaId(): void
    {
        $openId = 'oABC123456789';
        $title = '小程序标题';
        $pagePath = 'pages/index/index';
        $complexThumbMediaId = 'MEDIA_ID_12345-abc_DEF+67890';

        $this->mpPageMessage
            ->setAccount($this->account)
            ->setTouser($openId)
            ->setTitle($title)
            ->setPagePath($pagePath)
            ->setThumbMediaId($complexThumbMediaId);

        $result = $this->mpPageMessage->toArray();

        $this->assertSame($complexThumbMediaId, $result['miniprogrampage']['thumb_media_id']);
    }
}
