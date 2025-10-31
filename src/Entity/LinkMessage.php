<?php

namespace WechatMiniProgramCustomServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
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
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255, options: ['comment' => '图文链接消息描述'])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255, options: ['comment' => '图文链接消息跳转链接'])]
    #[Assert\NotBlank]
    #[Assert\Length(max: 255)]
    #[Assert\Url]
    private ?string $url = null;

    #[ORM\Column(length: 255, nullable: true, options: ['comment' => '图文链接消息的图片链接'])]
    #[Assert\Length(max: 255)]
    #[Assert\Url]
    private ?string $thumbUrl = null;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getThumbUrl(): ?string
    {
        return $this->thumbUrl;
    }

    public function setThumbUrl(?string $thumbUrl): void
    {
        $this->thumbUrl = $thumbUrl;
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
            'title' => $this->getTitle() ?? '',
            'description' => $this->getDescription() ?? '',
            'url' => $this->getUrl() ?? '',
        ];

        if (null !== $this->getThumbUrl()) {
            $link['thumb_url'] = $this->getThumbUrl();
        }

        return [
            'touser' => $this->getTouser() ?? '',
            'msgtype' => $this->getMsgtype(),
            'link' => $link,
        ];
    }

    public function __toString(): string
    {
        return (string) $this->getId();
    }
}
