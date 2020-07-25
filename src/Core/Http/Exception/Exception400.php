<?php

namespace SunFinance\Core\Http\Exception;

use SunFinance\Core\Http\AbstractResponse;

class Exception400 extends BaseException {

    /**
     * Exception400 constructor.
     *
     * @param mixed $message
     */
    public function __construct($message = null)
    {
        parent::__construct(
            $message ? json_encode($message) : '',
            AbstractResponse::RESPONSE_BAD_REQUEST
        );
    }
}
