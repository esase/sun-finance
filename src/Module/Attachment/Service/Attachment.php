<?php

namespace SunFinance\Module\Attachment\Service;

use SunFinance\Core\Db\DbService;
use SunFinance\Core\Utils\FileServiceInterface;
use Exception;
use PDO;

class Attachment
{
    const FILES_DIR = 'attachment';
    const FILES_PDF = '.pdf';

    /**
     * @var DbService
     */
    private $dbService;

    /**
     * @var FileServiceInterface
     */
    private $fileService;

    /**
     * Documents constructor.
     *
     * @param DbService     $dbService
     * @param FileServiceInterface   $fileService
     */
    public function __construct(
        DbService $dbService,
        FileServiceInterface $fileService
    ) {
        $this->dbService = $dbService;
        $this->fileService = $fileService;
    }

    /**
     * @param int   $documentId
     * @param array $file
     *
     * @return int
     * @throws Exception
     */
    public function create(int $documentId, array $file): int
    {
        // generate a new file name
        $fileName = time() . self::FILES_PDF;

        $sth = $this->dbService->getConnection()->prepare(
            'INSERT INTO attachments SET documentId = :documentId, file = :file'
        );
        $sth->bindValue(':documentId', $documentId, PDO::PARAM_INT);
        $sth->bindValue(':file', $fileName, PDO::PARAM_STR);
        $sth->execute();

        $attachmentId = (int)$this->dbService->getConnection()->lastInsertId();

        // move the received file
        $this->fileService->moveUploadedFile(
            $file['tmp_name'],
            $this->getAttachmentDir($attachmentId) . $fileName
        );

        return $attachmentId;
    }

    /**
     * @param int|null $attachmentId
     *
     * @return string
     * @throws Exception
     */
    protected function getAttachmentDir(int $attachmentId = null): string
    {
        return self::FILES_DIR . '/' . ($attachmentId ? $attachmentId . '/' : '');
    }
}
