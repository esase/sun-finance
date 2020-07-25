<?php

namespace SunFinance\Core\Form\Filter;

class HtmlEntities implements FilterInterface
{
    /**
     * @param mixed
     *
     * @return mixed
     */
    public function getValue($value)
    {
        return htmlentities($value, ENT_QUOTES);
    }
}
