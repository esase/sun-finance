<?php

namespace SunFinance\Core\Form\Validator;

interface ValidatorInterface
{
    /**
     * @param mixed
     *
     * @return bool
     */
    public function isValid($value): bool;

    /**
     * @param string $elementName
     *
     * @return string
     */
    public function getErrorMessage(string $elementName): string;
}
