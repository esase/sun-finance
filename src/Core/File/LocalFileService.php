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
     * @return string
     */
    public function getBaseDataDir(): string
    {
        return $this->dataDir;
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
        $to = $this->getBaseDataDir() . $to;

        if (!file_exists(dirname($to))) {
            // create a new directory
            $this->createDir(dirname($to), false);
        }

        return move_uploaded_file($from, $to);
    }

    /**
     * @param string $path
     * @param bool   $addBaseDataDir
     *
     * @return string
     */
    public function getFileUrl(string $path, $addBaseDataDir = true): string
    {
        if ($addBaseDataDir) {
            return $this->request->getHost() . '/' . $this->getBaseDataDir()
                . $path;
        }

        return $this->request->getHost() . '/' . $path;
    }

    /**
     * @param string $dir
     * @param array  $onlyType
     *
     * @return array
     */
    public function getFiles(string $dir, $onlyType = []): array
    {
        $dir = $this->getBaseDataDir() . $dir;
        $filter = $onlyType
            ? '.{' . implode(',', $onlyType) . '}'
            : '';

        return glob($dir . '*' . $filter, GLOB_BRACE);
    }

    /**
     * @param string $path
     */
    public function deleteFile(string $path)
    {
        $pathToDelete = $this->getBaseDataDir() . $path;

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

    /**
     * @param string $path
     * @param bool   $addBaseDataDir
     *
     * @return bool
     */
    public function createDir(string $path, $addBaseDataDir = true): bool
    {
        if ($addBaseDataDir) {
            $path = $this->getBaseDataDir() . $path;
        }

        return mkdir($path, self::DIRECTORY_PERMISSIONS, true);
    }

    /**
     * @param string $command
     *
     * @return mixed
     */
    public function runCommand(string $command)
    {
        exec($command);
    }
}
