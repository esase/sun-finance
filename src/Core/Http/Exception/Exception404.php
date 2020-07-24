<?php

namespace SunFinance\Core\Http\Exception;

use SunFinance\Core\Http\AbstractResponse;

class Exception404 extends BaseException {

    /**
     * Exception404 constructor.
     */
    public function __construct()
    {
        parent::__construct('', AbstractResponse::RESPONSE_NOT_FOUND);
    }
}
