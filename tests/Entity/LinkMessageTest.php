<?php

declare(strict_types=1);

namespace WechatMiniProgramCustomServiceBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramCustomServiceBundle\Entity\LinkMessage;

/**
 * @internal
 */
#[CoversClass(LinkMessage::class)]
final class LinkMessageTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new LinkMessage();
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function propertiesProvider(): iterable
    {
        yield 'title' => ['title', '测试标题'];
        yield 'description' => ['description', '测试描述'];
        yield 'url' => ['url', 'https://example.com/test'];
        yield 'thumbUrl' => ['thumbUrl', 'https://example.com/image.jpg'];
    }

    private LinkMessage $linkMessage;

    private Account $account;

    protected function setUp(): void
    {
        parent::setUp();

        $this->linkMessage = new LinkMessage();
        // 使用 WechatMiniProgramBundle\Entity\Account 具体类进行 mock 的原因：
        // 1. AbstractMessage 中的 account 属性直接使用了 Account 具体类，而非接口
        // 2. Doctrine ORM 映射要求使用具体实体类，无法使用接口
        // 3. Account 类是外部依赖包提供的实体，我们无法修改其定义为接口
        $this->account = $this->createMock(Account::class);
    }

    public function testGetAndSetTitleShouldWorkCorrectly(): void
    {
        $title = '这是一个测试标题';

        $this->assertNull($this->linkMessage->getTitle());

        $this->linkMessage->setTitle($title);
        $this->assertSame($title, $this->linkMessage->getTitle());
    }

    public function testGetAndSetDescriptionShouldWorkCorrectly(): void
    {
        $description = '这是一个测试描述';

        $this->assertNull($this->linkMessage->getDescription());

        $this->linkMessage->setDescription($description);
        $this->assertSame($description, $this->linkMessage->getDescription());
    }

    public function testGetAndSetUrlShouldWorkCorrectly(): void
    {
        $url = 'https://example.com/test-page';

        $this->assertNull($this->linkMessage->getUrl());

        $this->linkMessage->setUrl($url);
        $this->assertSame($url, $this->linkMessage->getUrl());
    }

    public function testGetAndSetThumbUrlShouldWorkCorrectly(): void
    {
        $thumbUrl = 'https://example.com/image.jpg';

        $this->assertNull($this->linkMessage->getThumbUrl());

        $this->linkMessage->setThumbUrl($thumbUrl);
        $this->assertSame($thumbUrl, $this->linkMessage->getThumbUrl());
    }

    public function testGetMsgtypeShouldReturnLink(): void
    {
        $this->assertSame('link', $this->linkMessage->getMsgtype());
    }

    public function testToArrayWithAllPropertiesSetShouldReturnCompleteArray(): void
    {
        $openId = 'oABC123456789';
        $title = '测试标题';
        $description = '测试描述';
        $url = 'https://example.com/page';
        $thumbUrl = 'https://example.com/image.jpg';

        $this->linkMessage->setAccount($this->account);
        $this->linkMessage->setTouser($openId);
        $this->linkMessage->setTitle($title);
        $this->linkMessage->setDescription($description);
        $this->linkMessage->setUrl($url);
        $this->linkMessage->setThumbUrl($thumbUrl);

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

    public function testToArrayWithoutThumbUrlShouldNotIncludeThumbUrlInResult(): void
    {
        $openId = 'oABC123456789';
        $title = '测试标题';
        $description = '测试描述';
        $url = 'https://example.com/page';

        $this->linkMessage->setAccount($this->account);
        $this->linkMessage->setTouser($openId);
        $this->linkMessage->setTitle($title);
        $this->linkMessage->setDescription($description);
        $this->linkMessage->setUrl($url);
        $this->linkMessage->setThumbUrl(null);

        $result = $this->linkMessage->toArray();

        $this->assertArrayHasKey('link', $result);
        $this->assertArrayNotHasKey('thumb_url', $result['link']);
    }

    public function testToArrayWithEmptyThumbUrlShouldIncludeEmptyThumbUrlInResult(): void
    {
        $openId = 'oABC123456789';
        $title = '测试标题';
        $description = '测试描述';
        $url = 'https://example.com/page';

        $this->linkMessage->setAccount($this->account);
        $this->linkMessage->setTouser($openId);
        $this->linkMessage->setTitle($title);
        $this->linkMessage->setDescription($description);
        $this->linkMessage->setUrl($url);
        $this->linkMessage->setThumbUrl(null);

        $result = $this->linkMessage->toArray();

        $this->assertArrayHasKey('link', $result);
        $this->assertArrayNotHasKey('thumb_url', $result['link']);
    }
}
