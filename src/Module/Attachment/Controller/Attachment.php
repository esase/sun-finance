<?php

namespace SunFinance\Module\Attachment\Controller;

use SunFinance\Core\Http\Exception\Exception400;
use SunFinance\Core\Http\Request;
use SunFinance\Module\Attachment\Service;
use SunFinance\Module\Attachment\Form;

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
     * Attachment constructor.
     *
     * @param Request                $request
     * @param Service\Attachment     $service
     * @param Form\AttachmentBuilder $formBuilder
     */
    public function __construct(
        Request $request,
        Service\Attachment $service,
        Form\AttachmentBuilder $formBuilder
    ) {
        $this->request = $request;
        $this->service = $service;
        $this->formBuilder = $formBuilder;
    }

    public function view()
    {
        return 'a';
    }

    /**
     * @throws Exception400
     */
    public function create()
    {
        // init the form
        $form = $this->formBuilder->initializeForm();
        $form->populateValues($_FILES);

        // create a new attachment
        if ($form->isValid()) {
            $attachmentId = $this->service->create(
                $form->getValue(Form\AttachmentBuilder::FILE)
            );
//
//            return $this->service->findOne($documentId);
        }

        throw new Exception400(
            $form->getErrors()
        );
    }

}
