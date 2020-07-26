<?php

use SunFinance\Core\Http;
use SunFinance\Core\Mvc;
use SunFinance\Module;

return [
    // document
    [
        'controller'  => Module\Document\Controller\Document::class,
        'action_list' => [
            Http\Request::METHOD_GET  => 'list',
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
    ],
    // attachment
    [
        'controller'  => Module\Attachment\Controller\Attachment::class,
        'action_list' => [
            Http\Request::METHOD_GET  => 'view',
            Http\Request::METHOD_POST => 'create'
        ],
        'method_list' => [
            Http\Request::METHOD_GET,
            Http\Request::METHOD_POST
        ],
        'uri'         => '|^/documents/(?P<id>\d+)/attachment$|i',
        'uri_params'  => ['id'],
        'type'        => Mvc\Route::TYPE_REGEXP
    ]
];
