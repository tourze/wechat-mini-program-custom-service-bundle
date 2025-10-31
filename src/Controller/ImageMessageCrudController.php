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
use WechatMiniProgramCustomServiceBundle\Entity\ImageMessage;

/**
 * 图片消息 CRUD 控制器
 */
#[AdminCrud(
    routePath: '/wechat-mini-program-custom-service/image-message',
    routeName: 'wechat_mini_program_custom_service_image_message'
)]
final class ImageMessageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ImageMessage::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('图片消息')
            ->setEntityLabelInPlural('图片消息')
            ->setPageTitle('index', '图片消息管理')
            ->setPageTitle('new', '创建图片消息')
            ->setPageTitle('edit', '编辑图片消息')
            ->setPageTitle('detail', '图片消息详情')
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
            ->add(TextFilter::new('mediaId', '媒体文件ID'))
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

            TextField::new('mediaId', '媒体文件ID')
                ->setMaxLength(255)
                ->setRequired(true)
                ->setHelp('通过新增临时素材接口上传多媒体文件获得的media_id'),

            DateTimeField::new('createTime', '创建时间')
                ->hideOnForm()
                ->setFormat('yyyy-MM-dd HH:mm:ss'),
        ];
    }

    public function createEntity(string $entityFqcn): ImageMessage
    {
        return new ImageMessage();
    }
}
