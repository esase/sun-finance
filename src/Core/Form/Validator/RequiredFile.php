<?php

namespace SunFinance\Core\Form\Validator;

class RequiredFile implements ValidatorInterface
{
    /**
     * @var bool
     */
    private $isMultiple;

    /**
     * RequiredFile constructor.
     *
     * @param bool $isMultiple
     */
    public function __construct(bool  $isMultiple = false)
    {
        $this->isMultiple = $isMultiple;
    }

    /**
     * @param mixed
     *
     * @return bool
     */
    public function isValid($value): bool
    {
        $file  = $value['tmp_name'] ?? null;
        $error = $value['error'] ?? null;

        if (!$this->isMultiple) {
            if (!is_array($file) && !is_array($error) && $file) {
                return $this->validateFile($file, $error);
            }
        }
        else {
            if (is_array($file) && is_array($error) && count($file)) {
                foreach ($file as $key => $fileName) {
                    $isValid =  $this->validateFile($fileName, $error[$key]);

                    if (!$isValid) {
                        return false;
                    }
                }

                return true;
            }
        }

        return false;
    }

    /**
     * @param string $elementName
     *
     * @return string
     */
    public function getErrorMessage(string $elementName): string
    {
        if (!$this->isMultiple) {
            return '`' . $elementName . '` is required';
        }

        return '`'. $elementName . '` is required. We expect an array of files';
    }

    /**
     * @param string $file
     * @param int    $error
     *
     * @return bool
     */
    protected function validateFile(string $file, int $error): bool
    {
        return is_uploaded_file($file) && !$error;
    }

    /**
     * @return bool
     */
    public function breakChainOfValidators(): bool
    {
        return true;
    }
}
