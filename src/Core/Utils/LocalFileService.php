<?php

namespace SunFinance\Core\Utils;

use SunFinance\Core\Config\ConfigService;
use Exception;

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
     * FileService constructor.
     *
     * @param ConfigService $configService
     *
     * @throws Exception
     */
    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
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
}
