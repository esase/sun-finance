<?php

use SunFinance\Core\Http;
use SunFinance\Core\Mvc;
use SunFinance\Core\Db;
use SunFinance\Core\Config;
use SunFinance\Core\File;
use SunFinance\Module;
use SunFinance\Core\ServiceManager\Factory\InvokableFactory;

return [
    // core
    Http\Request::class                             => Http\Factory\RequestFactory::class,
    Http\AbstractResponse::class                    => Http\Factory\ResponseFactory::class,
    Mvc\Router::class                               => Mvc\Factory\RouterFactory::class,
    Config\ConfigService::class                     => Config\Factory\ConfigServiceFactory::class,
    Db\DbService::class                             => Db\Factory\DbServiceFactory::class,
    File\LocalFileService::class                   => File\Factory\LocalFileServiceFactory::class,
    File\FileServiceInterface::class               => File\Factory\FileServiceFactory::class,

    // controller
    Module\Base\Controller\NotFound::class          => InvokableFactory::class,
    Module\Document\Controller\Document::class      => Module\Document\Controller\Factory\DocumentFactory::class,
    Module\Attachment\Controller\Attachment::class  => Module\Attachment\Controller\Factory\AttachmentFactory::class,

    // service
    Module\Document\Service\Document::class         => Module\Document\Service\Factory\DocumentFactory::class,
    Module\Attachment\Service\Attachment::class     => Module\Attachment\Service\Factory\AttachmentFactory::class,

    // form
    Module\Document\Form\DocumentBuilder::class     => Module\Document\Form\Factory\DocumentBuilderFactory::class,
    Module\Attachment\Form\AttachmentBuilder::class => Module\Attachment\Form\Factory\AttachmentBuilderFactory::class,
];
