<?php

namespace SunFinance\Core\Http;

abstract class AbstractResponse
{
    const RESPONSE_OK = 200;
    const RESPONSE_NOT_FOUND = 404;
    const RESPONSE_BAD_REQUEST = 400;
    const RESPONSE_CONFLICT = 409;

    protected $redirectCodes
        = [
            self::RESPONSE_OK          => 'HTTP/1.1 200 OK',
            self::RESPONSE_NOT_FOUND   => 'HTTP/1.1 404 Not Found',
            self::RESPONSE_BAD_REQUEST => 'HTTP/1.1 400 Bad Request',
            self::RESPONSE_CONFLICT    => 'HTTP/1.1 409 Conflict'
        ];

    /**
     * @var mixed
     */
    protected $response;

    /**
     * @var int
     */
    protected $responseCode = self::RESPONSE_OK;

    /**
     * @param mixed $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @param int $code
     */
    public function setResponseCode(int $code)
    {
        $this->responseCode = $code;
    }

    public abstract function displayResponse();

    /**
     * @param array $headers
     */
    protected function sendHeaders(array $headers)
    {
        foreach ($headers as $header) {
            header($header);
        }
    }
}
