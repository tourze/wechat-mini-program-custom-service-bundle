<?php

namespace WechatMiniProgramCustomServiceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use WechatMiniProgramCustomServiceBundle\Repository\ImageMessageRepository;

/**
 * 图片消息实体类
 *
 * 用于发送图片类型的客服消息。
 * 参考文档：https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/kf-mgnt/kf-message/sendCustomMessage.html
 */
#[ORM\Table(name: 'wechat_custom_service_image_message', options: ['comment' => '微信客服图片消息'])]
#[ORM\Entity(repositoryClass: ImageMessageRepository::class)]
class ImageMessage extends AbstractMessage
{
    #[ORM\Column(length: 255, options: ['comment' => '图片媒体文件ID'])]
    private ?string $mediaId = null;

    /**
     * 获取图片媒体文件ID
     */
    public function getMediaId(): ?string
    {
        return $this->mediaId;
    }

    /**
     * 设置图片媒体文件ID
     */
    public function setMediaId(string $mediaId): static
    {
        $this->mediaId = $mediaId;

        return $this;
    }

    public function getMsgtype(): string
    {
        return 'image';
    }

    /**
     * @return array{
     *     touser: string,
     *     msgtype: string,
     *     image: array{
     *         media_id: string
     *     }
     * }
     */
    public function toArray(): array
    {
        return [
            'touser' => $this->getTouser(),
            'msgtype' => $this->getMsgtype(),
            'image' => [
                'media_id' => $this->getMediaId(),
            ],
        ];
    }

    public function __toString(): string
    {
        return (string) $this->getId();
    }
}
