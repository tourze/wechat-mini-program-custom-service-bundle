<?php

namespace WechatMiniProgramCustomServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use WechatMiniProgramCustomServiceBundle\Repository\MpMessageRepository;

/**
 * 小程序卡片消息实体类
 *
 * 用于发送小程序卡片类型的客服消息。
 * 参考文档：https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/kf-mgnt/kf-message/sendCustomMessage.html
 */
#[ORM\Table(name: 'wechat_custom_service_mini_program_message', options: ['comment' => '微信客服小程序卡片消息'])]
#[ORM\Entity(repositoryClass: MpMessageRepository::class)]
class MpPageMessage extends AbstractMessage
{
    /**
     * 小程序卡片标题
     */
    #[ORM\Column(length: 255, options: ['comment' => '小程序卡片标题'])]
    private ?string $title = null;

    /**
     * 小程序的页面路径
     *
     * 跳转到小程序的页面路径，可带参数
     */
    #[ORM\Column(length: 255, options: ['comment' => '小程序页面路径'])]
    private ?string $pagePath = null;

    /**
     * 小程序卡片图片的媒体ID
     *
     * 可以通过文件上传接口获得
     */
    #[ORM\Column(length: 255, options: ['comment' => '小程序卡片图片的媒体ID'])]
    private ?string $thumbMediaId = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getPagePath(): ?string
    {
        return $this->pagePath;
    }

    public function setPagePath(string $pagePath): static
    {
        $this->pagePath = $pagePath;

        return $this;
    }

    public function getThumbMediaId(): ?string
    {
        return $this->thumbMediaId;
    }

    public function setThumbMediaId(string $thumbMediaId): static
    {
        $this->thumbMediaId = $thumbMediaId;

        return $this;
    }

    public function getMsgtype(): string
    {
        return 'miniprogrampage';
    }

    /**
     * @return array{
     *     touser: string,
     *     msgtype: string,
     *     miniprogrampage: array{
     *         title: string,
     *         pagepath: string,
     *         thumb_media_id: string
     *     }
     * }
     */
    public function toArray(): array
    {
        return [
            'touser' => $this->getTouser(),
            'msgtype' => $this->getMsgtype(),
            'miniprogrampage' => [
                'title' => $this->getTitle(),
                'pagepath' => $this->getPagePath(),
                'thumb_media_id' => $this->getThumbMediaId(),
            ],
        ];
    }
}
