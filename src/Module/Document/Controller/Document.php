<?php

namespace SunFinance\Module\Document\Controller;

use SunFinance\Core\Http\Exception\Exception400;
use SunFinance\Core\Http\Request;
use SunFinance\Module\Document\Service;
use SunFinance\Module\Document\Form;
use SunFinance\Core\Http\Exception\Exception404;
use Exception;

class Document
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Service\Document
     */
    private $service;

    /**
     * @var Form\DocumentBuilder
     */
    private $formBuilder;

    /**
     * Documents constructor.
     *
     * @param Request              $request
     * @param Service\Document     $service
     * @param Form\DocumentBuilder $formBuilder
     */
    public function __construct(
        Request $request,
        Service\Document $service,
        Form\DocumentBuilder $formBuilder
    ) {
        $this->request = $request;
        $this->service = $service;
        $this->formBuilder = $formBuilder;
    }

    /**
     * @return array
     */
    public function list()
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

    /**
     * @return array
     * @throws Exception
     */
    public function create(): array
    {
        // init the form
        $form = $this->formBuilder->initializeForm();
        $form->populateValues($_POST);

        // create a new document
        if ($form->isValid()) {
            $documentId = $this->service->create(
                $form->getValue(Form\DocumentBuilder::TITLE),
                $form->getValue(Form\DocumentBuilder::BODY)
            );

            return $this->service->findOne($documentId);
        }

        throw new Exception400(
            $form->getErrors()
        );
    }
}
