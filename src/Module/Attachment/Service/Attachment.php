<?php

namespace SunFinance\Module\Attachment\Service;

use SunFinance\Core\Db\DbService;
use PDO;

class Attachment
{
    /**
     * @var DbService
     */
    private $dbService;

    /**
     * Documents constructor.
     *
     * @param DbService $dbService
     */
    public function __construct(DbService $dbService)
    {
        $this->dbService = $dbService;
    }

    /**
     * @param array $file
     *
     * @return int
     */
    public function create(array $file): int
    {
        print_r($file);
        exit;
    }
}
