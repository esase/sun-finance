<?php

namespace SunFinance\Core\Http\Exception;

use SunFinance\Core\Http\AbstractResponse;

class Exception404 extends BaseException {

    /**
     * Exception404 constructor.
     *
     * @param mixed $message
     */
    public function __construct($message = null)
    {
        parent::__construct(
            $message ? json_encode($message) : '',
            AbstractResponse::RESPONSE_NOT_FOUND
        );
    }
}
