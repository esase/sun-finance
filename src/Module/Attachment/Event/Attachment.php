<?php

namespace SunFinance\Module\Attachment\Event;

use SunFinance\Core\Http\Request;
use SunFinance\Module\Attachment\Service;
use SunFinance\Module\Document\Controller\Document;
use Exception;

class Attachment
{
    /**
     * @var Service\Attachment
     */
    private $service;

    /**
     * @var Request
     */
    private $request;

    /**
     * Attachment constructor.
     *
     * @param Service\Attachment $service
     * @param Request            $request
     */
    public function __construct(
        Service\Attachment $service,
        Request $request
    ) {
        $this->service = $service;
        $this->request = $request;
    }

    /**
     * @param array|null $params
     *
     * @throws Exception
     */
    public function afterControllerActionCalling($params = null)
    {
        $controller = $params['controller'] ?? '';
        $action = $params['action'] ?? '';

        // delete attachments
        if ($controller === Document::class && $action === 'delete') {
            $this->service->deleteOneByDocumentId(
                $this->request->getUriParam('id')
            );
        }
    }
}
