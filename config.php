<?php

use SunFinance\Core\Http;
use SunFinance\Core\Mvc;
use SunFinance\Core\Db;
use SunFinance\Core\Config;
use SunFinance\Module;
use SunFinance\Core\ServiceManager\Factory\InvokableFactory;

return [
    'db'              => [
        'host'     => 'mysql',
        'username' => 'root',
        'password' => 'sun-finance-root',
        'db_name'  => 'sun-finance-db',
    ],
    'response'        => 'json',
    'routes'          => [
        [
            'controller'  => Module\Document\Controller\Document::class,
            'action_list' => [
                Http\Request::METHOD_GET => 'list',
                Http\Request::METHOD_POST => 'create'
            ],
            'method_list' => [
                Http\Request::METHOD_GET,
                Http\Request::METHOD_POST
            ],
            'uri'         => '/documents'
        ],
        [
            'controller'  => Module\Document\Controller\Document::class,
            'action_list' => [
                Http\Request::METHOD_GET    => 'view',
                Http\Request::METHOD_DELETE => 'delete'
            ],
            'method_list' => [
                Http\Request::METHOD_GET,
                Http\Request::METHOD_DELETE
            ],
            'uri'         => '|^/documents/(?P<id>\d+)$|i',
            'uri_params'  => ['id'],
            'type'        => Mvc\Route::TYPE_REGEXP
        ]
    ],
    'service_manager' => [
        // core
        Http\Request::class                         => Http\Factory\RequestFactory::class,
        Http\AbstractResponse::class                => Http\Factory\ResponseFactory::class,
        Mvc\Router::class                           => Mvc\Factory\RouterFactory::class,
        Config\ConfigService::class                 => Config\Factory\ConfigServiceFactory::class,
        Db\DbService::class                         => Db\Factory\DbServiceFactory::class,

        // controller
        Module\Base\Controller\NotFound::class      => InvokableFactory::class,
        Module\Document\Controller\Document::class  => Module\Document\Controller\Factory\DocumentFactory::class,

        // service
        Module\Document\Service\Document::class     => Module\Document\Service\Factory\DocumentFactory::class,

        // form
        Module\Document\Form\DocumentBuilder::class => Module\Document\Form\Factory\DocumentBuilderFactory::class,
    ]
];