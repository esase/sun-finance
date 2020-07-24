<?php

namespace SunFinance\Core\Http\Exception;

class Exception404 extends BaseException {

    /**
     * Exception404 constructor.
     */
    public function __construct()
    {
        parent::__construct('', 404);
    }
}
