<?php

namespace WechatMiniProgramCustomServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
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
    #[ORM\Column(length: 255, options: ['comment' => '小程序卡片标题'])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, options: ['comment' => '小程序页面路径'])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $pagePath = null;

    #[ORM\Column(length: 255, options: ['comment' => '小程序卡片图片的媒体ID'])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $thumbMediaId = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getPagePath(): ?string
    {
        return $this->pagePath;
    }

    public function setPagePath(string $pagePath): void
    {
        $this->pagePath = $pagePath;
    }

    public function getThumbMediaId(): ?string
    {
        return $this->thumbMediaId;
    }

    public function setThumbMediaId(string $thumbMediaId): void
    {
        $this->thumbMediaId = $thumbMediaId;
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
            'touser' => $this->getTouser() ?? '',
            'msgtype' => $this->getMsgtype(),
            'miniprogrampage' => [
                'title' => $this->getTitle() ?? '',
                'pagepath' => $this->getPagePath() ?? '',
                'thumb_media_id' => $this->getThumbMediaId() ?? '',
            ],
        ];
    }

    public function __toString(): string
    {
        return (string) $this->getId();
    }
}
