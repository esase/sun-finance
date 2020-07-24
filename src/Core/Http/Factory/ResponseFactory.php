<?php

namespace SunFinance\Core\Http\Factory;

use SunFinance\Core\Config\ConfigService;
use SunFinance\Core\Http\JsonResponse;
use SunFinance\Core\Http\AbstractResponse;
use SunFinance\Core\ServiceManager\ServiceManager;
use Exception;

class ResponseFactory
{
    /**
     * @param ServiceManager $serviceManager
     *
     * @return AbstractResponse
     * @throws Exception
     */
    public function __invoke(ServiceManager $serviceManager): AbstractResponse
    {
        /** @var ConfigService $configService */
        $configService = $serviceManager->getInstance(ConfigService::class);
        $responseType = $configService->getConfig('response');

        switch ($responseType) {
            case 'json':
            default:
                return new JsonResponse();
        }
    }
}