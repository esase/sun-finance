<?php

use SunFinance\Core\Router;
use SunFinance\Modules\Documents\Controllers;

return [
    'routes' => [
        [
            'method' => Router\Router::METHOD_GET,
            'uri' => '/documents',
            'controller' => Controllers\Documents::class,
            'action' => 'index'
        ]
    ]
];