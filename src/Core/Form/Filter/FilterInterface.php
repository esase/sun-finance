<?php

namespace SunFinance\Core\Form\Filter;

interface FilterInterface
{
    /**
     * @param mixed
     *
     * @return mixed
     */
    public function getValue($value);
}
