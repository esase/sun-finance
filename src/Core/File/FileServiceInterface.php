<?php

namespace SunFinance\Core\File;

use Exception;

interface FileServiceInterface
{
    /**
     * @return string
     */
    public function getBaseDataDir(): string;

    /**
     * @param string $from
     * @param string $to
     *
     * @return bool
     * @throws Exception
     */
    public function moveUploadedFile(string $from, string $to): bool;

    /**
     * @param string $path
     *
     * @return string
     */
    public function getFileUrl(string $path): string;

    /**
     * @param string $dir
     * @param array  $onlyType
     *
     * @return array
     */
    public function getFiles(string $dir, $onlyType = []): array;

    /**
     * @param string $path
     *
     * @return mixed
     */
    public function deleteFile(string $path);

    /**
     * @param string $path
     *
     * @return bool
     */
    public function createDir(string $path): bool;

    /**
     * @param string $command
     *
     * @return mixed
     */
    public function runCommand(string $command);
}
