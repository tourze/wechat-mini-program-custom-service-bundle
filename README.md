# WeChat Mini Program Custom Service Bundle

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/wechat-mini-program-custom-service-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-mini-program-custom-service-bundle)
[![PHP Version](https://img.shields.io/packagist/php-v/tourze/wechat-mini-program-custom-service-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-mini-program-custom-service-bundle)
[![Build Status](https://img.shields.io/github/actions/workflow/status/tourze/php-monorepo/ci.yml?style=flat-square)](https://github.com/tourze/php-monorepo/actions)
[![Code Coverage](https://img.shields.io/codecov/c/github/tourze/php-monorepo?style=flat-square)](https://codecov.io/gh/tourze/php-monorepo)
[![License](https://img.shields.io/packagist/l/tourze/wechat-mini-program-custom-service-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-mini-program-custom-service-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/wechat-mini-program-custom-service-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/wechat-mini-program-custom-service-bundle)

A Symfony bundle for managing WeChat Mini Program custom service messages, providing comprehensive support for sending various message types including text, images, links, and mini program pages.

## Features

- 🎯 **Multiple Message Types**: Support for text, image, link, and mini program page messages
- 📦 **Doctrine Integration**: Full ORM support with entity repositories
- 🔄 **Event System**: Event subscribers for message handling
- 🚀 **Easy Configuration**: Symfony bundle with auto-configuration
- 📝 **Type Safety**: Comprehensive type annotations and PHPStan level 5 compliance
- ✅ **Fully Tested**: 100% test coverage with PHPUnit

## Dependencies

This bundle requires:

- PHP 8.1 or higher
- Symfony 6.4 or higher
- Doctrine ORM 3.0 or higher
- tourze/wechat-mini-program-bundle

## Installation

```bash
composer require tourze/wechat-mini-program-custom-service-bundle
```

### 1. Register the Bundle

Add the bundle to your `config/bundles.php`:

```php
return [
    // ... other bundles
    WechatMiniProgramCustomServiceBundle\WechatMiniProgramCustomServiceBundle::class => ['all' => true],
];
```

### 2. Configure Database

Run database migrations to create the message tables:

```bash
php bin/console doctrine:migrations:migrate
```

## Quick Start

```php
use WechatMiniProgramCustomServiceBundle\Entity\TextMessage;
use WechatMiniProgramCustomServiceBundle\Request\SendMessageRequest;

// Create a text message
$textMessage = new TextMessage();
$textMessage->setTouser('user_openid');
$textMessage->setContent('Hello from WeChat Mini Program!');
$textMessage->setAccount($account);

// Send the message
$request = new SendMessageRequest();
$request->setMessage($textMessage);
$request->setAccount($account);

// Use your HTTP client to send the request
```

## Advanced Usage

### Message Types

#### Text Message
```php
$textMessage = new TextMessage();
$textMessage->setTouser('user_openid')
           ->setContent('Your message content')
           ->setAccount($account);
```

#### Image Message
```php
$imageMessage = new ImageMessage();
$imageMessage->setTouser('user_openid')
            ->setMediaId('media_id_from_wechat')
            ->setAccount($account);
```

#### Link Message
```php
$linkMessage = new LinkMessage();
$linkMessage->setTouser('user_openid')
           ->setTitle('Link Title')
           ->setDescription('Link Description')
           ->setUrl('https://example.com')
           ->setThumbUrl('https://example.com/thumb.jpg')
           ->setAccount($account);
```

#### Mini Program Page Message
```php
$mpPageMessage = new MpPageMessage();
$mpPageMessage->setTouser('user_openid')
             ->setTitle('Page Title')
             ->setPagePath('pages/index/index')
             ->setThumbMediaId('thumb_media_id')
             ->setAccount($account);
```

### Configuration

The bundle provides auto-configuration for all services. Simply register the bundle and the services will be available for dependency injection.

```yaml
# config/services.yaml
services:
    # Services are auto-configured
    _defaults:
        autowire: true
        autoconfigure: true
```

### Event System

The bundle includes an event listener for message handling:

```php
use WechatMiniProgramCustomServiceBundle\EventSubscriber\MessageListener;

// The MessageListener automatically handles message events
// when integrated with the WeChat Mini Program bundle
```

## API Reference

For detailed API documentation, please refer to:
- [WeChat Mini Program Custom Message API](https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/kf-mgnt/kf-message/sendCustomMessage.html)

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.