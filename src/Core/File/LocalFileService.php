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

    /**
     * @param string $path
     */
    public function deleteFile(string $path)
    {
        $pathToDelete = $this->dataDir . $path;

        // scan for files
        if (is_dir($pathToDelete)) {
            $objects = scandir($pathToDelete);

            foreach ($objects as $object) {
                if ($object != '.' && $object != '..') {
                    if (is_dir($pathToDelete . DIRECTORY_SEPARATOR . $object)
                        && !is_link($pathToDelete . '/' . $object)) {
                        $this->deleteFile(
                            $path . DIRECTORY_SEPARATOR . $object
                        );
                    } else {
                        unlink($pathToDelete . DIRECTORY_SEPARATOR . $object);
                    }
                }
            }

            rmdir($pathToDelete);

            return;
        }

        unlink($pathToDelete);
    }
}
