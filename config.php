<?php

use SunFinance\Module;

return [
    'db'              => [
        'host'     => 'mysql',
        'username' => 'root',
        'password' => 'sun-finance-root',
        'db_name'  => 'sun-finance-db',
    ],
    'response'        => 'json',
    'routes'          => require_once 'config-router.php',
    'service_manager' => require_once 'config-service-manager.php'
];
