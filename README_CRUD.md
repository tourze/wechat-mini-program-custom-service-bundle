# 微信小程序客服消息 EasyAdmin CRUD 使用指南

本文档说明如何使用新创建的 EasyAdmin CRUD 控制器来管理微信小程序客服消息。

## 功能概述

已为以下实体创建了完整的 CRUD 管理界面：

1. **文本消息 (TextMessage)** - 管理文本类型的客服消息
2. **图片消息 (ImageMessage)** - 管理图片类型的客服消息
3. **链接消息 (LinkMessage)** - 管理图文链接类型的客服消息
4. **小程序卡片消息 (MpPageMessage)** - 管理小程序卡片类型的客服消息

## 文件结构

```
src/
├── Controller/
│   ├── TextMessageCrudController.php       # 文本消息 CRUD 控制器
│   ├── ImageMessageCrudController.php      # 图片消息 CRUD 控制器
│   ├── LinkMessageCrudController.php       # 链接消息 CRUD 控制器
│   └── MpPageMessageCrudController.php     # 小程序卡片消息 CRUD 控制器
├── Service/
│   ├── AdminMenu.php                       # 菜单配置服务
│   └── AttributeControllerLoader.php       # 控制器属性加载器
└── Resources/config/
    └── services.yaml                       # 服务配置

tests/
├── Controller/                             # 控制器测试
└── Service/                               # 服务测试
```

## 使用方法

### 1. 集成到 EasyAdmin Dashboard

在你的 EasyAdmin Dashboard 控制器中添加菜单项：

```php
<?php

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use WechatMiniProgramCustomServiceBundle\Service\AdminMenu;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminMenu $adminMenu
    ) {}

    public function configureMenuItems(): iterable
    {
        // 其他菜单项...

        // 添加小程序客服消息菜单
        yield from $this->adminMenu->getMenuItems();

        // 或者作为子菜单
        yield $this->adminMenu->getMainMenuItem();
    }
}
```

### 2. 直接使用控制器

也可以直接在路由中使用各个控制器：

```php
// 在你的路由配置中
use WechatMiniProgramCustomServiceBundle\Controller\TextMessageCrudController;

// 访问 /admin?crudAction=index&crudControllerFqcn=WechatMiniProgramCustomServiceBundle\Controller\TextMessageCrudController
```

### 3. 自定义控制器行为

继承控制器并重写方法来自定义行为：

```php
<?php

use WechatMiniProgramCustomServiceBundle\Controller\TextMessageCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class CustomTextMessageCrudController extends TextMessageCrudController
{
    public function configureCrud(Crud $crud): Crud
    {
        return parent::configureCrud($crud)
            ->setPageTitle('index', '自定义文本消息管理');
    }
}
```

## 字段说明

### 文本消息 (TextMessage)
- **ID**: 消息唯一标识
- **小程序账号**: 关联的微信小程序账号
- **接收用户OpenID**: 消息接收用户的OpenID
- **消息内容**: 要发送的文本内容（最大65535字符）
- **创建时间**: 消息创建时间（自动生成）

### 图片消息 (ImageMessage)
- **ID**: 消息唯一标识
- **小程序账号**: 关联的微信小程序账号
- **接收用户OpenID**: 消息接收用户的OpenID
- **媒体文件ID**: 通过微信接口上传获得的media_id
- **创建时间**: 消息创建时间（自动生成）

### 链接消息 (LinkMessage)
- **ID**: 消息唯一标识
- **小程序账号**: 关联的微信小程序账号
- **接收用户OpenID**: 消息接收用户的OpenID
- **消息标题**: 图文链接消息标题
- **消息描述**: 图文链接消息描述
- **跳转链接**: 点击后跳转的URL
- **图片链接**: 消息配图链接（可选）
- **创建时间**: 消息创建时间（自动生成）

### 小程序卡片消息 (MpPageMessage)
- **ID**: 消息唯一标识
- **小程序账号**: 关联的微信小程序账号
- **接收用户OpenID**: 消息接收用户的OpenID
- **卡片标题**: 小程序卡片标题
- **页面路径**: 小程序页面路径（如：pages/index/index）
- **缩略图媒体ID**: 卡片图片的媒体ID（建议尺寸520*416）
- **创建时间**: 消息创建时间（自动生成）

## 权限配置

默认所有操作都需要 `ROLE_ADMIN` 权限。如需自定义权限，可以重写控制器的 `configureActions` 方法：

```php
public function configureActions(Actions $actions): Actions
{
    return $actions
        ->setPermission(Action::NEW, 'ROLE_MANAGER')
        ->setPermission(Action::EDIT, 'ROLE_MANAGER')
        ->setPermission(Action::DELETE, 'ROLE_SUPER_ADMIN');
}
```

## 服务使用

### AdminMenu 服务

```php
// 获取所有菜单项
$menuItems = $adminMenuService->getMenuItems();

// 获取主菜单项（包含子菜单）
$mainMenuItem = $adminMenuService->getMainMenuItem();
```

### AttributeControllerLoader 服务

```php
// 获取所有控制器
$controllers = $loaderService->getCrudControllers();

// 检查是否为本Bundle的控制器
$isOwn = $loaderService->isOwnController(TextMessageCrudController::class);

// 获取控制器显示名称
$displayName = $loaderService->getDisplayName(TextMessageCrudController::class);
```

## 扩展性

本实现遵循最佳实践，支持以下扩展：

1. **自定义字段显示**: 重写 `configureFields` 方法
2. **自定义操作**: 重写 `configureActions` 方法
3. **自定义过滤器**: 添加 `configureFilters` 方法
4. **自定义批量操作**: 添加批量操作配置
5. **事件监听**: 利用 EasyAdmin 的事件系统

## 注意事项

1. 确保已正确配置微信小程序账号实体的关联关系
2. 媒体文件ID需要通过微信API上传后获得
3. 所有URL字段会自动进行格式验证
4. 创建时间字段在实体构造时自动设置，无需手动设置