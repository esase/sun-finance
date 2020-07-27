<?php

namespace SunFinance\Module\Attachment\Service;

use SunFinance\Core\Db\DbService;
use SunFinance\Core\File\LocalFileService;
use Exception;
use PDO;

class Attachment
{
    const FILES_DIR = 'attachment';
    const IMAGES_DIR = 'images';
    const FILES_EXTENSION = '.pdf';
    const IMAGES_EXTENSION = 'jpg';

    /**
     * @var DbService
     */
    private $dbService;

    /**
     * @var LocalFileService
     */
    private $localFileService;

    /**
     * Documents constructor.
     *
     * @param DbService        $dbService
     * @param LocalFileService $fileService
     */
    public function __construct(
        DbService $dbService,
        LocalFileService $fileService
    ) {
        $this->dbService = $dbService;
        $this->localFileService = $fileService;
    }

    /**
     * @param int $id
     *
     * @throws Exception
     */
    public function deleteOneByDocumentId(int $id)
    {
        $attachment = $this->findOneByDocumentId($id);

        if ($attachment) {
            $sth = $this->dbService->getConnection()->prepare(
                'DELETE FROM attachments WHERE documentId = :id'
            );
            $sth->bindValue(':id', $id, PDO::PARAM_INT);
            $sth->execute();

            $this->localFileService->deleteFile(
                $this->getAttachmentDir($attachment['id'])
            );
        }
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
     * @param int $attachmentId
     * @param int $imageId
     *
     * @return array
     */
    public function findImage(int $attachmentId, int $imageId): array
    {
        $images = $this->getAllImages($attachmentId);

        if ($images && isset($images[$imageId])) {
            return [
                'id' => $imageId,
                'url' => $this->localFileService->getFileUrl(
                    $images[$imageId], false
                )
            ];
        }

        return [];
    }

    /**
     * @param int $attachmentId
     *
     * @return array
     */
    public function findAllImages(int $attachmentId): array
    {
        $images = $this->getAllImages($attachmentId);

        // add url
        if ($images) {
            array_walk($images, function (&$value, $key) {
                $value = [
                    'id' => $key,
                    'url' => $this->localFileService->getFileUrl(
                        $value,
                        false
                    )
                ];
            });
        }

        return $images;
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
        $this->localFileService->moveUploadedFile(
            $file['tmp_name'],
            $this->getAttachmentDir($attachmentId) . $fileName
        );

        // create a directory for previews
        $this->localFileService->createDir(
            $this->getAttachmentDir($attachmentId, true)
        );

        // extract images from the uploaded pdf file
        $this->localFileService->runCommand(vsprintf('pdfimages -j %s%s %s%spreview', [
            $this->localFileService->getBaseDataDir(),
            $this->getAttachmentDir($attachmentId) . $fileName,
            $this->localFileService->getBaseDataDir(),
            $this->getAttachmentDir($attachmentId, true)
        ]));

        return $attachmentId;
    }

    /**
     * @param int|null $attachmentId
     *
     * @param bool     $isImage
     *
     * @return string
     */
    protected function getAttachmentDir(
        int $attachmentId = null,
        $isImage = false
    ): string {
        $path = self::FILES_DIR . '/' . ($attachmentId ? $attachmentId . '/' : '');

        if ($isImage) {
            $path .= self::IMAGES_DIR . '/';
        }

        return $path;
    }

    /**
     * @param array $attachment
     *
     * @return array
     * @throws Exception
     */
    protected function processAttachment(array $attachment)
    {
        $attachment['file'] = $this->localFileService->getFileUrl(
            $this->getAttachmentDir($attachment['id']) . $attachment['file']
        );

        return $attachment;
    }


    /**
     * @param int $attachmentId
     *
     * @return array
     */
    protected function getAllImages(int $attachmentId): array
    {
        return $this->localFileService->getFiles(
            $this->getAttachmentDir($attachmentId, true),
            [self::IMAGES_EXTENSION]
        );
    }

}
