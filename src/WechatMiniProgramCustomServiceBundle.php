<?php

namespace WechatMiniProgramCustomServiceBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Tourze\BundleDependency\BundleDependencyInterface;
use Tourze\EasyAdmin\Attribute\Permission\AsPermission;

#[AsPermission(title: '小程序客服')]
class WechatMiniProgramCustomServiceBundle extends Bundle implements BundleDependencyInterface
{
    public static function getBundleDependencies(): array
    {
        return [
            \WechatMiniProgramBundle\WechatMiniProgramBundle::class => ['all' => true],
        ];
    }
}
