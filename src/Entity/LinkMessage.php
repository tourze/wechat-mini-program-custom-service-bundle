<?php

namespace WechatMiniProgramCustomServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use WechatMiniProgramCustomServiceBundle\Repository\LinkMessageRepository;

/**
 * 图文链接消息实体类
 *
 * 用于发送图文链接类型的客服消息。
 * 参考文档：https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/kf-mgnt/kf-message/sendCustomMessage.html
 */
#[ORM\Table(name: 'wechat_custom_service_link_message', options: ['comment' => '微信客服图文链接消息'])]
#[ORM\Entity(repositoryClass: LinkMessageRepository::class)]
class LinkMessage extends AbstractMessage
{
    #[ORM\Column(length: 255, options: ['comment' => '消息标题'])]
    private ?string $title = null;

    #[ORM\Column(length: 255, options: ['comment' => '图文链接消息描述'])]
    private ?string $description = null;

    #[ORM\Column(length: 255, options: ['comment' => '图文链接消息跳转链接'])]
    private ?string $url = null;

    #[ORM\Column(length: 255, nullable: true, options: ['comment' => '图文链接消息的图片链接'])]
    private ?string $thumbUrl = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getThumbUrl(): ?string
    {
        return $this->thumbUrl;
    }

    public function setThumbUrl(?string $thumbUrl): static
    {
        $this->thumbUrl = $thumbUrl;

        return $this;
    }

    public function getMsgtype(): string
    {
        return 'link';
    }

    /**
     * @return array{
     *     touser: string,
     *     msgtype: string,
     *     link: array{
     *         title: string,
     *         description: string,
     *         url: string,
     *         thumb_url?: string
     *     }
     * }
     */
    public function toArray(): array
    {
        $link = [
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'url' => $this->getUrl(),
        ];

        if ($this->getThumbUrl() !== null) {
            $link['thumb_url'] = $this->getThumbUrl();
        }

        return [
            'touser' => $this->getTouser(),
            'msgtype' => $this->getMsgtype(),
            'link' => $link,
        ];
    }

    public function __toString(): string
    {
        return (string) $this->getId();
    }
}
