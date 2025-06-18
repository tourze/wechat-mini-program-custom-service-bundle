<?php

namespace WechatMiniProgramCustomServiceBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use WechatMiniProgramCustomServiceBundle\Repository\TextMessageRepository;

/**
 * 文本消息实体类
 *
 * 用于发送文本类型的客服消息。
 * 参考文档：https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/kf-mgnt/kf-message/sendCustomMessage.html
 */
#[ORM\Table(name: 'wechat_custom_service_text_message', options: ['comment' => '微信客服文本消息'])]
#[ORM\Entity(repositoryClass: TextMessageRepository::class)]
class TextMessage extends AbstractMessage
{
    #[ORM\Column(type: Types::TEXT, options: ['comment' => '消息文本内容'])]
    private ?string $content = null;

    /**
     * 获取消息文本内容
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * 设置消息文本内容
     */
    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getMsgtype(): string
    {
        return 'text';
    }

    /**
     * @return array{
     *     touser: string,
     *     msgtype: string,
     *     text: array{
     *         content: string
     *     }
     * }
     */
    public function toArray(): array
    {
        return [
            'touser' => $this->getTouser(),
            'msgtype' => $this->getMsgtype(),
            'text' => [
                'content' => $this->getContent(),
            ],
        ];
    }

    public function __toString(): string
    {
        return (string) $this->getId();
    }
}
