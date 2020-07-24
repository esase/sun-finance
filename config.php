<?php

use SunFinance\Core\Http;
use SunFinance\Core\Mvc;
use SunFinance\Core\Db;
use SunFinance\Core\Config;
use SunFinance\Modules;
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
            'controller' => Modules\Documents\Controllers\Documents::class,
            'action'     => 'list',
            'method'     => Http\Request::METHOD_GET,
            'uri'        => '/documents'
        ],
        [
            'controller' => Modules\Documents\Controllers\Documents::class,
            'action'     => 'view',
            'method'     => Http\Request::METHOD_GET,
            'uri'        => '|^/documents/(?P<id>\d+)$|i',
            'uri_params' => ['id'],
            'type'       => Mvc\Route::TYPE_REGEXP
        ]
    ],
    'service_manager' => [
        // core
        Http\Request::class                            => Http\Factory\RequestFactory::class,
        Http\AbstractResponse::class                   => Http\Factory\ResponseFactory::class,
        Mvc\Router::class                              => Mvc\Factory\RouterFactory::class,
        Config\ConfigService::class                    => Config\Factory\ConfigServiceFactory::class,
        Db\DbService::class                            => Db\Factory\DbServiceFactory::class,

        // controllers
        Modules\Base\Controllers\NotFound::class       => InvokableFactory::class,
        Modules\Documents\Controllers\Documents::class => Modules\Documents\Controllers\Factory\DocumentsFactory::class,

        // services
        Modules\Documents\Services\Documents::class    => Modules\Documents\Services\Factory\DocumentsFactory::class
    ]
];