<?php

namespace SunFinance\Core\File;

use Exception;

interface FileServiceInterface
{

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
     * @param string $path
     *
     * @return mixed
     */
    public function deleteFile(string $path);
}
