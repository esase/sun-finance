<?php

namespace SunFinance\Module\Document\Service;

use SunFinance\Core\Db\DbService;
use PDO;

class Document
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
     * @return array
     */
    public function findAll(): array
    {
        $sth = $this->dbService->getConnection()->prepare(
        'SELECT * from documents'
        );
        $sth->execute();

        return $sth->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param int $id
     *
     * @return array|bool
     */
    public function findOne(int $id)
    {
        $sth = $this->dbService->getConnection()->prepare(
            'SELECT * FROM documents WHERE id = :id'
        );
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();

        return $sth->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param int $id
     */
    public function deleteOne(int $id)
    {
        $sth = $this->dbService->getConnection()->prepare(
            'DELETE FROM documents WHERE id = :id'
        );
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();
    }
}
