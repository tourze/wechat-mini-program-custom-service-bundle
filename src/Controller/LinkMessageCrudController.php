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
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use WechatMiniProgramCustomServiceBundle\Entity\LinkMessage;

/**
 * 链接消息 CRUD 控制器
 */
#[AdminCrud(
    routePath: '/wechat-mini-program-custom-service/link-message',
    routeName: 'wechat_mini_program_custom_service_link_message'
)]
final class LinkMessageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LinkMessage::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('链接消息')
            ->setEntityLabelInPlural('链接消息')
            ->setPageTitle('index', '链接消息管理')
            ->setPageTitle('new', '创建链接消息')
            ->setPageTitle('edit', '编辑链接消息')
            ->setPageTitle('detail', '链接消息详情')
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
            ->add(TextFilter::new('title', '消息标题'))
            ->add(TextFilter::new('description', '消息描述'))
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

            TextField::new('title', '消息标题')
                ->setMaxLength(255)
                ->setRequired(true)
                ->setHelp('图文链接消息标题'),

            TextField::new('description', '消息描述')
                ->setMaxLength(255)
                ->setRequired(true)
                ->setHelp('图文链接消息描述'),

            UrlField::new('url', '跳转链接')
                ->setRequired(true)
                ->setHelp('图文链接消息跳转链接'),

            UrlField::new('thumbUrl', '图片链接')
                ->setRequired(false)
                ->setHelp('图文链接消息的图片链接，支持JPG、PNG格式，较好的效果为大图 640*320，小图 80*80'),

            DateTimeField::new('createTime', '创建时间')
                ->hideOnForm()
                ->setFormat('yyyy-MM-dd HH:mm:ss'),
        ];
    }

    public function createEntity(string $entityFqcn): LinkMessage
    {
        return new LinkMessage();
    }
}
