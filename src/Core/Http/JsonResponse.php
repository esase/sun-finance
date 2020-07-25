<?php

namespace SunFinance\Core\Http;

class JsonResponse extends AbstractResponse
{
    public function displayResponse()
    {
        $this->sendHeaders(
            [
                $this->redirectCodes[$this->responseCode],
                'Content-Type: application/json; charset=utf-8'
            ]
        );

        if ($this->response) {
            echo !$this->isJSON($this->response)
                ? json_encode($this->response)
                : $this->response;
        }
    }

    /**
     * @param mixed $string
     *
     * @return bool
     */
    protected function isJSON($string): bool
    {
        return is_string($string)
            && is_array(json_decode($string, true))
            && (json_last_error() == JSON_ERROR_NONE) ? true : false;
    }
}
