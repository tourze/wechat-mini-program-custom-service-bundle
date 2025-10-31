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
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;
use WechatMiniProgramCustomServiceBundle\Entity\TextMessage;

/**
 * 文本消息 CRUD 控制器
 */
#[AdminCrud(
    routePath: '/wechat-mini-program-custom-service/text-message',
    routeName: 'wechat_mini_program_custom_service_text_message'
)]
final class TextMessageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return TextMessage::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('文本消息')
            ->setEntityLabelInPlural('文本消息')
            ->setPageTitle('index', '文本消息管理')
            ->setPageTitle('new', '创建文本消息')
            ->setPageTitle('edit', '编辑文本消息')
            ->setPageTitle('detail', '文本消息详情')
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
            ->add(TextFilter::new('content', '消息内容'))
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

            TextareaField::new('content', '消息内容')
                ->setMaxLength(65535)
                ->setRequired(true)
                ->setNumOfRows(5)
                ->setHelp('要发送的文本消息内容'),

            DateTimeField::new('createTime', '创建时间')
                ->hideOnForm()
                ->setFormat('yyyy-MM-dd HH:mm:ss'),
        ];
    }

    public function createEntity(string $entityFqcn): TextMessage
    {
        return new TextMessage();
    }
}
