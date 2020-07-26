<?php

namespace SunFinance\Module\Attachment\Controller;

use SunFinance\Core\Http\Exception\Exception400;
use SunFinance\Core\Http\Exception\Exception404;
use SunFinance\Core\Http\Exception\Exception409;
use SunFinance\Core\Http\Request;
use SunFinance\Module\Attachment\Service;
use SunFinance\Module\Attachment\Form;
use SunFinance\Module\Document\Service as DocumentService;
use Exception;

class Attachment
{
    /**
     * @var Request
     */
    private $request;

    /**
     * @var Service\Attachment
     */
    private $service;

    /**
     * @var Form\AttachmentBuilder
     */
    private $formBuilder;

    /**
     * @var DocumentService\Document
     */
    private $documentService;

    /**
     * Attachment constructor.
     *
     * @param Request                  $request
     * @param Service\Attachment       $service
     * @param Form\AttachmentBuilder   $formBuilder
     * @param DocumentService\Document $documentService
     */
    public function __construct(
        Request $request,
        Service\Attachment $service,
        Form\AttachmentBuilder $formBuilder,
        DocumentService\Document $documentService
    ) {
        $this->request = $request;
        $this->service = $service;
        $this->formBuilder = $formBuilder;
        $this->documentService = $documentService;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function view(): array
    {
        $documentId = (int) $this->request->getUriParam('id');

        $attachment = $this->service->findOneByDocumentId($documentId);

        if (!$attachment) {
            throw new Exception404();
        }

        return $attachment;
    }

    /**
     * @return array
     * @throws Exception400
     * @throws Exception404
     * @throws Exception409
     * @throws Exception
     */
    public function create(): array
    {
        $documentId = (int) $this->request->getUriParam('id');

        // check if there is a document
        if (!$this->documentService->findOne($documentId)) {
            throw new Exception404('Document is missing');
        }

        // check if there is an uploaded attachment
        if ($this->service->isExist($documentId)) {
            throw new Exception409('Attachment is already uploaded');
        }

        // init the form
        $form = $this->formBuilder->initializeForm();
        $form->populateValues($_FILES);

        // create a new attachment
        if ($form->isValid()) {
            $attachmentId = $this->service->create(
                $documentId,
                $form->getValue(Form\AttachmentBuilder::FILE)
            );

            return $this->service->findOne($attachmentId);
        }

        throw new Exception400(
            $form->getErrors()
        );
    }
}
