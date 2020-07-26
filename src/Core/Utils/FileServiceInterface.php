<?php

namespace SunFinance\Core\Utils;

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
}
