<?php

use SunFinance\Core\Event;
use SunFinance\Module;

return [
    Event\Event::AFTER_CALLING_CONTROLLER => [
        Module\Attachment\Event\Attachment::class => 'afterControllerActionCalling'
    ]
];
