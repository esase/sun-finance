<?php

namespace SunFinance\Core\Form\Validator;

class FileMimeType implements ValidatorInterface
{
    /**
     * @var array
     */
    private $allowedMimeTypes;

    /**
     * @var bool
     */
    private $isMultiple;

    /**
     * FileMimeType constructor.
     *
     * @param array $allowedMimeTypes
     * @param bool  $isMultiple
     */
    public function __construct(
        array $allowedMimeTypes,
        bool $isMultiple = false
    ) {
        $this->allowedMimeTypes = $allowedMimeTypes;
        $this->isMultiple = $isMultiple;
    }

    /**
     * @param mixed
     *
     * @return bool
     */
    public function isValid($value): bool
    {
        $file = $value['tmp_name'] ?? null;
        $error = $value['error'] ?? null;
        $fileType = $value['type'] ?? null;

        if (!$this->isMultiple) {
            // we expect only a one uploaded file
            if (is_array($file) && is_array($fileType)) {
                return false;
            }

            if ($file || $error) {
                return $this->validateFile((string)$file, $fileType, $error);
            }
        } else {
            if ($file || $error) {
                // we expect multiple uploaded files
                if (!is_array($file) && !is_array($fileType)) {
                    return false;
                }

                if (count($file)) {
                    foreach ($file as $key => $fileName) {
                        $isValid = $this->validateFile(
                            (string)$fileName, $fileType[$key], $error[$key]
                        );

                        if (!$isValid) {
                            return false;
                        }
                    }

                    return true;
                }
            }
        }

        return true;
    }

    /**
     * @param string $elementName
     *
     * @return string
     */
    public function getErrorMessage(string $elementName): string
    {
        if (!$this->isMultiple) {
            return '`' . $elementName
                . '` must be uploaded and has correct mime types: '
                . implode(',', $this->allowedMimeTypes);
        }

        return '`' . $elementName
            . '` must be uploaded. We expect an array of files with these mime types: '
            . implode(',', $this->allowedMimeTypes);
    }

    /**
     * @return bool
     */
    public function breakChainOfValidators(): bool
    {
        return true;
    }

    /**
     * @param string $file
     * @param string $type
     * @param int    $error
     *
     * @return bool
     */
    protected function validateFile(
        string $file,
        string $type,
        int $error = 0
    ): bool {
        return is_uploaded_file($file) && !$error
            && in_array(
                $type, $this->allowedMimeTypes
            );
    }
}
