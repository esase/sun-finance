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

        if ($this->responseCode === AbstractResponse::RESPONSE_OK) {
            echo json_encode($this->response);
        }
    }
}
