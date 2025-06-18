<?php

namespace WechatMiniProgramCustomServiceBundle\Tests\Entity;

use PHPUnit\Framework\TestCase;
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramCustomServiceBundle\Entity\LinkMessage;

class LinkMessageTest extends TestCase
{
    private LinkMessage $linkMessage;
    private Account $account;

    protected function setUp(): void
    {
        $this->linkMessage = new LinkMessage();
        $this->account = $this->createMock(Account::class);
    }

    public function testGetAndSetTitle_shouldWorkCorrectly(): void
    {
        $title = '这是一个测试标题';

        $this->assertNull($this->linkMessage->getTitle());

        $result = $this->linkMessage->setTitle($title);

        $this->assertSame($this->linkMessage, $result);
        $this->assertSame($title, $this->linkMessage->getTitle());
    }

    public function testGetAndSetDescription_shouldWorkCorrectly(): void
    {
        $description = '这是一个测试描述';

        $this->assertNull($this->linkMessage->getDescription());

        $result = $this->linkMessage->setDescription($description);

        $this->assertSame($this->linkMessage, $result);
        $this->assertSame($description, $this->linkMessage->getDescription());
    }

    public function testGetAndSetUrl_shouldWorkCorrectly(): void
    {
        $url = 'https://example.com/test-page';

        $this->assertNull($this->linkMessage->getUrl());

        $result = $this->linkMessage->setUrl($url);

        $this->assertSame($this->linkMessage, $result);
        $this->assertSame($url, $this->linkMessage->getUrl());
    }

    public function testGetAndSetThumbUrl_shouldWorkCorrectly(): void
    {
        $thumbUrl = 'https://example.com/image.jpg';

        $this->assertNull($this->linkMessage->getThumbUrl());

        $result = $this->linkMessage->setThumbUrl($thumbUrl);

        $this->assertSame($this->linkMessage, $result);
        $this->assertSame($thumbUrl, $this->linkMessage->getThumbUrl());
    }

    public function testGetMsgtype_shouldReturnLink(): void
    {
        $this->assertSame('link', $this->linkMessage->getMsgtype());
    }

    public function testToArray_withAllPropertiesSet_shouldReturnCompleteArray(): void
    {
        $openId = 'oABC123456789';
        $title = '测试标题';
        $description = '测试描述';
        $url = 'https://example.com/page';
        $thumbUrl = 'https://example.com/image.jpg';

        $this->linkMessage
            ->setAccount($this->account)
            ->setTouser($openId)
            ->setTitle($title)
            ->setDescription($description)
            ->setUrl($url)
            ->setThumbUrl($thumbUrl);

        $expected = [
            'touser' => $openId,
            'msgtype' => 'link',
            'link' => [
                'title' => $title,
                'description' => $description,
                'url' => $url,
                'thumb_url' => $thumbUrl,
            ],
        ];

        $this->assertEquals($expected, $this->linkMessage->toArray());
    }

    public function testToArray_withoutThumbUrl_shouldNotIncludeThumbUrlInResult(): void
    {
        $openId = 'oABC123456789';
        $title = '测试标题';
        $description = '测试描述';
        $url = 'https://example.com/page';

        $this->linkMessage
            ->setAccount($this->account)
            ->setTouser($openId)
            ->setTitle($title)
            ->setDescription($description)
            ->setUrl($url)
            ->setThumbUrl(null);

        $result = $this->linkMessage->toArray();

        $this->assertArrayHasKey('link', $result);
        $this->assertArrayNotHasKey('thumb_url', $result['link']);
    }

    public function testToArray_withEmptyThumbUrl_shouldIncludeEmptyThumbUrlInResult(): void
    {
        $openId = 'oABC123456789';
        $title = '测试标题';
        $description = '测试描述';
        $url = 'https://example.com/page';

        $this->linkMessage
            ->setAccount($this->account)
            ->setTouser($openId)
            ->setTitle($title)
            ->setDescription($description)
            ->setUrl($url)
            ->setThumbUrl(null);

        $result = $this->linkMessage->toArray();

        $this->assertArrayHasKey('link', $result);
        $this->assertArrayNotHasKey('thumb_url', $result['link']);
    }
}
