<?php

declare(strict_types=1);

namespace WechatMiniProgramCustomServiceBundle\Service;

use Symfony\Bundle\FrameworkBundle\Routing\AttributeRouteControllerLoader;
use Symfony\Component\Config\Loader\Loader;
use Symfony\Component\DependencyInjection\Attribute\Autoconfigure;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\Routing\RouteCollection;
use Tourze\RoutingAutoLoaderBundle\Service\RoutingAutoLoaderInterface;
use WechatMiniProgramCustomServiceBundle\Controller\ImageMessageCrudController;
use WechatMiniProgramCustomServiceBundle\Controller\LinkMessageCrudController;
use WechatMiniProgramCustomServiceBundle\Controller\MpPageMessageCrudController;
use WechatMiniProgramCustomServiceBundle\Controller\TextMessageCrudController;

#[AutoconfigureTag(name: 'routing.loader')]
#[Autoconfigure(public: true)]
final class AttributeControllerLoader extends Loader implements RoutingAutoLoaderInterface
{
    private AttributeRouteControllerLoader $controllerLoader;

    public function __construct()
    {
        parent::__construct();
        $this->controllerLoader = new AttributeRouteControllerLoader();
    }

    public function load(mixed $resource, ?string $type = null): RouteCollection
    {
        return $this->autoload();
    }

    public function supports(mixed $resource, ?string $type = null): bool
    {
        return false;
    }

    public function autoload(): RouteCollection
    {
        $collection = new RouteCollection();
        $collection->addCollection($this->controllerLoader->load(TextMessageCrudController::class));
        $collection->addCollection($this->controllerLoader->load(ImageMessageCrudController::class));
        $collection->addCollection($this->controllerLoader->load(LinkMessageCrudController::class));
        $collection->addCollection($this->controllerLoader->load(MpPageMessageCrudController::class));

        return $collection;
    }
}
