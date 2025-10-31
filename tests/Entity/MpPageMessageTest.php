<?php

declare(strict_types=1);

namespace WechatMiniProgramCustomServiceBundle\Tests\Entity;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Tourze\PHPUnitDoctrineEntity\AbstractEntityTestCase;
use WechatMiniProgramBundle\Entity\Account;
use WechatMiniProgramCustomServiceBundle\Entity\MpPageMessage;

/**
 * @internal
 */
#[CoversClass(MpPageMessage::class)]
final class MpPageMessageTest extends AbstractEntityTestCase
{
    protected function createEntity(): object
    {
        return new MpPageMessage();
    }

    /**
     * @return iterable<string, array{string, string}>
     */
    public static function propertiesProvider(): iterable
    {
        yield 'title' => ['title', '小程序标题'];
        yield 'pagePath' => ['pagePath', '/pages/index/index'];
        yield 'thumbMediaId' => ['thumbMediaId', 'MEDIA_ID_123456'];
    }

    private MpPageMessage $mpPageMessage;

    private Account $account;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mpPageMessage = new MpPageMessage();

        // 使用 WechatMiniProgramBundle\Entity\Account 具体类进行 mock 的原因：
        // 1. AbstractMessage 中的 account 属性直接使用了 Account 具体类，而非接口
        // 2. Doctrine ORM 映射要求使用具体实体类，无法使用接口
        // 3. Account 类是外部依赖包提供的实体，我们无法修改其定义为接口
        $this->account = $this->createMock(Account::class);
    }

    public function testGetAndSetTitleShouldWorkCorrectly(): void
    {
        $title = '小程序标题';

        $this->assertNull($this->mpPageMessage->getTitle());

        $this->mpPageMessage->setTitle($title);
        $this->assertSame($title, $this->mpPageMessage->getTitle());
    }

    public function testGetAndSetPagePathShouldWorkCorrectly(): void
    {
        $pagePath = 'pages/index/index?param=value';

        $this->assertNull($this->mpPageMessage->getPagePath());

        $this->mpPageMessage->setPagePath($pagePath);
        $this->assertSame($pagePath, $this->mpPageMessage->getPagePath());
    }

    public function testGetAndSetThumbMediaIdShouldWorkCorrectly(): void
    {
        $thumbMediaId = 'MEDIA_ID_12345';

        $this->assertNull($this->mpPageMessage->getThumbMediaId());

        $this->mpPageMessage->setThumbMediaId($thumbMediaId);
        $this->assertSame($thumbMediaId, $this->mpPageMessage->getThumbMediaId());
    }

    public function testGetMsgtypeShouldReturnMiniprogrampage(): void
    {
        $this->assertSame('miniprogrampage', $this->mpPageMessage->getMsgtype());
    }

    public function testToArrayWithAllPropertiesSetShouldReturnCompleteArray(): void
    {
        $openId = 'oABC123456789';
        $title = '小程序标题';
        $pagePath = 'pages/index/index?param=value';
        $thumbMediaId = 'MEDIA_ID_12345';

        $this->mpPageMessage->setAccount($this->account);
        $this->mpPageMessage->setTouser($openId);
        $this->mpPageMessage->setTitle($title);
        $this->mpPageMessage->setPagePath($pagePath);
        $this->mpPageMessage->setThumbMediaId($thumbMediaId);

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

    public function testToArrayWithEmptyTitleShouldReturnArrayWithEmptyTitle(): void
    {
        $openId = 'oABC123456789';
        $emptyTitle = '';
        $pagePath = 'pages/index/index';
        $thumbMediaId = 'MEDIA_ID_12345';

        $this->mpPageMessage->setAccount($this->account);
        $this->mpPageMessage->setTouser($openId);
        $this->mpPageMessage->setTitle($emptyTitle);
        $this->mpPageMessage->setPagePath($pagePath);
        $this->mpPageMessage->setThumbMediaId($thumbMediaId);

        $result = $this->mpPageMessage->toArray();

        $this->assertSame($emptyTitle, $result['miniprogrampage']['title']);
    }

    public function testToArrayWithLongPathIncludingParamsShouldReturnArrayWithFullPath(): void
    {
        $openId = 'oABC123456789';
        $title = '小程序标题';
        $longPagePath = 'pages/detail/detail?id=12345&ref=share&user=test&from=timeline&scene=12345';
        $thumbMediaId = 'MEDIA_ID_12345';

        $this->mpPageMessage->setAccount($this->account);
        $this->mpPageMessage->setTouser($openId);
        $this->mpPageMessage->setTitle($title);
        $this->mpPageMessage->setPagePath($longPagePath);
        $this->mpPageMessage->setThumbMediaId($thumbMediaId);

        $result = $this->mpPageMessage->toArray();

        $this->assertSame($longPagePath, $result['miniprogrampage']['pagepath']);
    }

    public function testToArrayWithComplexThumbMediaIdShouldReturnArrayWithCorrectThumbMediaId(): void
    {
        $openId = 'oABC123456789';
        $title = '小程序标题';
        $pagePath = 'pages/index/index';
        $complexThumbMediaId = 'MEDIA_ID_12345-abc_DEF+67890';

        $this->mpPageMessage->setAccount($this->account);
        $this->mpPageMessage->setTouser($openId);
        $this->mpPageMessage->setTitle($title);
        $this->mpPageMessage->setPagePath($pagePath);
        $this->mpPageMessage->setThumbMediaId($complexThumbMediaId);

        $result = $this->mpPageMessage->toArray();

        $this->assertSame($complexThumbMediaId, $result['miniprogrampage']['thumb_media_id']);
    }
}
