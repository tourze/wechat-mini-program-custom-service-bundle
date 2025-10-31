<?php

namespace WechatMiniProgramCustomServiceBundle\Request;

use WechatMiniProgramBundle\Request\WithAccountRequest;
use WechatMiniProgramCustomServiceBundle\Entity\AbstractMessage;

class SendMessageRequest extends WithAccountRequest
{
    private AbstractMessage $message;

    public function getRequestPath(): string
    {
        return 'https://api.weixin.qq.com/cgi-bin/message/custom/send';
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getRequestOptions(): ?array
    {
        return [
            'json' => $this->getMessage()->toArray(),
        ];
    }

    public function getRequestMethod(): ?string
    {
        return 'POST';
    }

    public function getMessage(): AbstractMessage
    {
        return $this->message;
    }

    public function setMessage(AbstractMessage $message): void
    {
        $this->message = $message;
    }
}
