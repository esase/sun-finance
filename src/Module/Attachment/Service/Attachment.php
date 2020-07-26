<?php

namespace SunFinance\Module\Attachment\Service;

use SunFinance\Core\Db\DbService;
use SunFinance\Core\File\FileServiceInterface;
use Exception;
use PDO;

class Attachment
{
    const FILES_DIR = 'attachment';
    const FILES_EXTENSION = '.pdf';

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
     * @param int $id
     *
     * @return array|bool
     * @throws Exception
     */
    public function findOneByDocumentId(int $id)
    {
        $sth = $this->dbService->getConnection()->prepare(
            'SELECT * FROM attachments WHERE documentId = :id'
        );
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();

        $result = $sth->fetch(PDO::FETCH_ASSOC);

        return $result ? $this->processAttachment($result) : false;
    }

    /**
     * @param int $id
     *
     * @return array|bool
     * @throws Exception
     */
    public function findOne(int $id)
    {
        $sth = $this->dbService->getConnection()->prepare(
            'SELECT * FROM attachments WHERE id = :id'
        );
        $sth->bindValue(':id', $id, PDO::PARAM_INT);
        $sth->execute();

        $result = $sth->fetch(PDO::FETCH_ASSOC);

        return $result ? $this->processAttachment($result) : false;
    }

    /**
     * @param int $documentId
     *
     * @return bool
     */
    public function isExist(int $documentId): bool
    {
        $sth = $this->dbService->getConnection()->prepare(
            'SELECT COUNT(*) FROM attachments WHERE documentId = :id'
        );
        $sth->bindValue(':id', $documentId, PDO::PARAM_INT);
        $sth->execute();

        return $sth->fetchColumn() > 0;
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
        $fileName = time() . self::FILES_EXTENSION;

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

    /**
     * @param array $attachment
     *
     * @return array
     * @throws Exception
     */
    protected function processAttachment(array $attachment)
    {
        $attachment['file'] = $this->fileService->getFileUrl(
            $this->getAttachmentDir($attachment['id']) . $attachment['file']
        );

        return $attachment;
    }
}
