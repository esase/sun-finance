<?php

use SunFinance\Core\Config;
use SunFinance\Core\Router;
use SunFinance\Core\ServiceManager\Factory\InvokableFactory;
use SunFinance\Modules\Base\Controllers\NotFound;
use SunFinance\Modules\Documents\Controllers\Documents;

return [
    Router\Router::class => Router\Factory\RouterFactory::class,
    Config\Config::class => Config\Factory\ConfigFactory::class,
    Documents::class     => InvokableFactory::class,
    NotFound::class      => InvokableFactory::class
];
