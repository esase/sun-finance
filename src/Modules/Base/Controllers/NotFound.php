<?php

namespace SunFinance\Modules\Base\Controllers;

use SunFinance\Core\Http\Exception\Exception404;

class NotFound
{
    /**
     * @throws Exception404
     */
    public function index()
    {
        throw new Exception404();
    }
}
