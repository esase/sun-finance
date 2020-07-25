<?php

namespace SunFinance\Modules\Documents\Controllers;

use SunFinance\Core\Http\Request;
use SunFinance\Modules\Documents\Services;
use SunFinance\Core\Http\Exception\Exception404;
use Exception;

class Documents
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Services\Documents
     */
    private $service;

    /**
     * Documents constructor.
     *
     * @param Request   $request
     * @param Services\Documents $service
     */
    public function __construct(
        Request $request,
        Services\Documents $service
    ) {
        $this->request = $request;
        $this->service = $service;
    }

    /**
     * @return array
     */
    public function list(): array
    {
        return $this->service->findAll();
    }

    /**
     * @return array
     * @throws Exception404
     * @throws Exception
     */
    public function view()
    {
        $id = (int) $this->request->getUriParam('id');
        $document = $this->service->findOne($id);

        if (!$document) {
            throw new Exception404();
        }

        return $document;
    }

    /**
     * @return array
     * @throws Exception404
     * @throws Exception
     */
    public function delete(): array
    {
        $id = (int) $this->request->getUriParam('id');
        $document = $this->service->findOne($id);

        if (!$document) {
            throw new Exception404();
        }

        $this->service->deleteOne($id);

        return [];
    }

}

