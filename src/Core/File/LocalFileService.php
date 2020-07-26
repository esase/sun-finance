<?php

namespace SunFinance\Core\File;

use SunFinance\Core\Config\ConfigService;
use Exception;
use SunFinance\Core\Http\Request;

class LocalFileService implements FileServiceInterface
{
    const DIRECTORY_PERMISSIONS = 0755;

    /**
     * @var ConfigService
     */
    private $configService;

    /**
     * @var string
     */
    private $dataDir;

    /**
     * @var Request
     */
    private $request;

    /**
     * FileService constructor.
     *
     * @param ConfigService $configService
     * @param Request       $request
     *
     * @throws Exception
     */
    public function __construct(
        ConfigService $configService,
        Request $request
    ) {
        $this->configService = $configService;
        $this->request = $request;
        $this->dataDir = $this->configService->getConfig('data_dir');
    }

    /**
     * @param string $from
     * @param string $to
     *
     * @return bool
     * @throws Exception
     */
    public function moveUploadedFile(string $from, string $to): bool
    {
        $to = $this->dataDir . $to;

        if (!file_exists(dirname($to))) {
            // create a new directory
            mkdir(dirname($to), self::DIRECTORY_PERMISSIONS, true);
        }

        return move_uploaded_file($from, $to);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public function getFileUrl(string $path): string
    {
        return $this->request->getHost() . '/' . $this->dataDir . $path;
    }
}
