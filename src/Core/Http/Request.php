<?php

namespace SunFinance\Core\Http;

use Exception;

class Request
{
    const METHOD_POST = 'POST';
    const METHOD_GET = 'GET';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';
    const METHOD_ALL = '*';

    const BASE_SCRIPT_NAME = '/index.php';

    /**
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $scriptName;

    /**
     * @var array
     */
    private $uriParams = [];

    /**
     * Request constructor.
     *
     * @param string $uri
     * @param string $method
     * @param string $scriptName
     */
    public function __construct(
        string $uri,
        string $method,
        string $scriptName
    ) {
        $this->uri = $uri;
        $this->method = $method;
        $this->scriptName = $scriptName;
    }

    /**
     * @return string
     */
    public function getUriPath(): string
    {
        $requestedUri = parse_url($this->uri, PHP_URL_PATH);

        // remove the base script name from the requested uri (we may be worked from a sub dir)
        $scriptPath = str_replace(
            self::BASE_SCRIPT_NAME,
            '',
            $this->scriptName
        );
        return strtolower(str_replace($scriptPath, '', $requestedUri));
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param array $params
     */
    public function setUriParams(array $params)
    {
        $this->uriParams = $params;
    }

    /**
     * @param string $name
     *
     * @return mixed
     * @throws Exception
     */
    public function getUriParam(string $name)
    {
        if (isset($this->uriParams[$name])) {
            return $this->uriParams[$name];
        }

        throw new Exception('Uri param `' . $name. '` not found');
    }
}
