<?php

declare(strict_types=1);

namespace WechatMiniProgramCustomServiceBundle\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use Tourze\PHPUnitSymfonyKernelTest\AbstractBundleTestCase;
use WechatMiniProgramCustomServiceBundle\WechatMiniProgramCustomServiceBundle;

/**
 * @internal
 */
#[CoversClass(WechatMiniProgramCustomServiceBundle::class)]
#[RunTestsInSeparateProcesses]
final class WechatMiniProgramCustomServiceBundleTest extends AbstractBundleTestCase
{
}
