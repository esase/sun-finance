<?php

use SunFinance\Core\Router\Router;
use SunFinance\Modules\Documents\Controllers;

return [
    'routes' => [
        [
            'method' => Router::METHOD_GET,
            'uri' => '/documents',
            'controller' => Controllers\Documents::class,
            'action' => 'index'
        ]
    ]
];