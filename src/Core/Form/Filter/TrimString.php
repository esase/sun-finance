<?php

namespace SunFinance\Core\Form\Filter;

class TrimString implements FilterInterface
{
    /**
     * @param mixed
     *
     * @return mixed
     */
    public function getValue($value)
    {
        return trim($value);
    }
}
