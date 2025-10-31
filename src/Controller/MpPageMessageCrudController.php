<?php

declare(strict_types=1);

namespace WechatMiniProgramCustomServiceBundle\Controller;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminCrud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use WechatMiniProgramCustomServiceBundle\Entity\MpPageMessage;

/**
 * 小程序卡片消息 CRUD 控制器
 */
#[AdminCrud(
    routePath: '/wechat-mini-program-custom-service/mp-page-message',
    routeName: 'wechat_mini_program_custom_service_mp_page_message'
)]
final class MpPageMessageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MpPageMessage::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('小程序卡片消息')
            ->setEntityLabelInPlural('小程序卡片消息')
            ->setPageTitle('index', '小程序卡片消息管理')
            ->setPageTitle('new', '创建小程序卡片消息')
            ->setPageTitle('edit', '编辑小程序卡片消息')
            ->setPageTitle('detail', '小程序卡片消息详情')
            ->setDefaultSort(['id' => 'DESC'])
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->setPermission(Action::NEW, 'ROLE_ADMIN')
            ->setPermission(Action::EDIT, 'ROLE_ADMIN')
            ->setPermission(Action::DELETE, 'ROLE_ADMIN')
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('account', '小程序账号'))
            ->add(TextFilter::new('touser', '接收用户OpenID'))
            ->add(TextFilter::new('title', '卡片标题'))
            ->add(TextFilter::new('pagePath', '页面路径'))
            ->add(TextFilter::new('thumbMediaId', '缩略图媒体ID'))
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'ID')
                ->hideOnForm(),

            AssociationField::new('account', '小程序账号')
                ->setRequired(true)
                ->autocomplete(),

            TextField::new('touser', '接收用户OpenID')
                ->setMaxLength(255)
                ->setRequired(true)
                ->setHelp('消息接收用户的OpenID'),

            TextField::new('title', '卡片标题')
                ->setMaxLength(255)
                ->setRequired(true)
                ->setHelp('小程序卡片标题'),

            TextField::new('pagePath', '页面路径')
                ->setMaxLength(255)
                ->setRequired(true)
                ->setHelp('小程序页面路径，例如：pages/index/index'),

            TextField::new('thumbMediaId', '缩略图媒体ID')
                ->setMaxLength(255)
                ->setRequired(true)
                ->setHelp('小程序卡片图片的媒体ID，建议大小为 520*416'),

            DateTimeField::new('createTime', '创建时间')
                ->hideOnForm()
                ->setFormat('yyyy-MM-dd HH:mm:ss'),
        ];
    }

    public function createEntity(string $entityFqcn): MpPageMessage
    {
        return new MpPageMessage();
    }
}
