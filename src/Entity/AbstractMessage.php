<?php

namespace WechatMiniProgramCustomServiceBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use WechatMiniProgramBundle\Entity\Account;

/**
 * 微信小程序客服消息抽象基类
 *
 * 该类作为所有客服消息类型的基类，提供了共同的属性和方法。
 * 每个具体的消息类型都需要继承此类并实现特定的消息结构。
 */
#[ORM\MappedSuperclass]
abstract class AbstractMessage
{
    /**
     * 消息ID
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(options: ['comment' => '消息ID'])]
    protected ?int $id = null;

    /**
     * 关联的微信小程序账号
     */
    #[ORM\ManyToOne(targetEntity: Account::class, cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Account $account = null;

    /**
     * 接收消息的用户OpenID
     */
    #[ORM\Column(length: 255, options: ['comment' => '接收消息的用户OpenID'])]
    private ?string $touser = null;

    /**
     * 消息创建时间
     */
    #[ORM\Column(type: Types::DATETIME_IMMUTABLE, options: ['comment' => '消息创建时间'])]
    private \DateTimeImmutable $createTime;

    public function __construct()
    {
        $this->createTime = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): void
    {
        $this->account = $account;
    }

    public function getTouser(): ?string
    {
        return $this->touser;
    }

    public function setTouser(string $touser): void
    {
        $this->touser = $touser;
    }

    public function getCreateTime(): \DateTimeImmutable
    {
        return $this->createTime;
    }

    /**
     * 获取消息类型
     *
     * @return string 返回消息类型标识符
     */
    abstract public function getMsgtype(): string;

    /**
     * 将消息转换为数组格式
     *
     * 用于将消息转换为符合微信API要求的数组格式。
     * 每个具体的消息类型都需要实现此方法，确保返回正确的消息结构。
     *
     * @return array<string, mixed> 返回符合微信API格式的消息数组
     */
    abstract public function toArray(): array;
}
