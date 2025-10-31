# 微信小程序客服消息包

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/wechat-mini-program-custom-service-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-mini-program-custom-service-bundle)
[![PHP Version](https://img.shields.io/packagist/php-v/tourze/wechat-mini-program-custom-service-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-mini-program-custom-service-bundle)
[![Build Status](https://img.shields.io/github/actions/workflow/status/tourze/php-monorepo/ci.yml?style=flat-square)](https://github.com/tourze/php-monorepo/actions)
[![Code Coverage](https://img.shields.io/codecov/c/github/tourze/php-monorepo?style=flat-square)](https://codecov.io/gh/tourze/php-monorepo)
[![License](https://img.shields.io/packagist/l/tourze/wechat-mini-program-custom-service-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-mini-program-custom-service-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/wechat-mini-program-custom-service-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-mini-program-custom-service-bundle)

一个用于管理微信小程序客服消息的 Symfony 包，全面支持发送文本、图片、链接和小程序页面等多种消息类型。

## 功能特性

- 🎯 **多种消息类型**：支持文本、图片、链接和小程序页面消息
- 📦 **Doctrine 集成**：完整的 ORM 支持和实体仓储
- 🔄 **事件系统**：消息处理的事件订阅者
- 🚀 **简易配置**：Symfony 包自动配置
- 📝 **类型安全**：完整的类型注解和 PHPStan level 5 合规性
- ✅ **完全测试**：PHPUnit 100% 测试覆盖

## 依赖要求

此包需要：

- PHP 8.1 或更高版本
- Symfony 6.4 或更高版本
- Doctrine ORM 3.0 或更高版本
- tourze/wechat-mini-program-bundle

## 安装

```bash
composer require tourze/wechat-mini-program-custom-service-bundle
```

### 1. 注册包

将包添加到您的 `config/bundles.php`：

```php
return [
    // ... 其他包
    WechatMiniProgramCustomServiceBundle\WechatMiniProgramCustomServiceBundle::class => ['all' => true],
];
```

### 2. 配置数据库

运行数据库迁移以创建消息表：

```bash
php bin/console doctrine:migrations:migrate
```

## 快速开始

```php
use WechatMiniProgramCustomServiceBundle\Entity\TextMessage;
use WechatMiniProgramCustomServiceBundle\Request\SendMessageRequest;

// 创建文本消息
$textMessage = new TextMessage();
$textMessage->setTouser('user_openid');
$textMessage->setContent('来自微信小程序的问候！');
$textMessage->setAccount($account);

// 发送消息
$request = new SendMessageRequest();
$request->setMessage($textMessage);
$request->setAccount($account);

// 使用您的 HTTP 客户端发送请求
```

## 高级用法

### 消息类型

#### 文本消息
```php
$textMessage = new TextMessage();
$textMessage->setTouser('user_openid')
           ->setContent('您的消息内容')
           ->setAccount($account);
```

#### 图片消息
```php
$imageMessage = new ImageMessage();
$imageMessage->setTouser('user_openid')
            ->setMediaId('来自微信的媒体ID')
            ->setAccount($account);
```

#### 链接消息
```php
$linkMessage = new LinkMessage();
$linkMessage->setTouser('user_openid')
           ->setTitle('链接标题')
           ->setDescription('链接描述')
           ->setUrl('https://example.com')
           ->setThumbUrl('https://example.com/thumb.jpg')
           ->setAccount($account);
```

#### 小程序页面消息
```php
$mpPageMessage = new MpPageMessage();
$mpPageMessage->setTouser('user_openid')
             ->setTitle('页面标题')
             ->setPagePath('pages/index/index')
             ->setThumbMediaId('缩略图媒体ID')
             ->setAccount($account);
```

### 配置

该包为所有服务提供自动配置。只需注册包，服务就可以用于依赖注入。

```yaml
# config/services.yaml
services:
    # 服务自动配置
    _defaults:
        autowire: true
        autoconfigure: true
```

### 事件系统

包包含用于消息处理的事件监听器：

```php
use WechatMiniProgramCustomServiceBundle\EventSubscriber\MessageListener;

// MessageListener 会在与微信小程序包集成时
// 自动处理消息事件
```

## API 参考

详细的 API 文档请参考：
- [微信小程序客服消息 API](https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/kf-mgnt/kf-message/sendCustomMessage.html)

## 贡献

欢迎提交 Issue 和 Pull Request。详情请参阅 [CONTRIBUTING.md](CONTRIBUTING.md)。

## 许可证

本项目基于 MIT 许可证开源。详情请参阅 [LICENSE](LICENSE) 文件。