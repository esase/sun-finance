<?php

namespace SunFinance\Module\Document\Form;

use SunFinance\Core\Form\AbstractFormBuilder;
use SunFinance\Core\Form\Filter\HtmlEntities;
use SunFinance\Core\Form\Filter\TrimString;
use SunFinance\Core\Form\Form;
use SunFinance\Core\Form\Validator\Required;

class DocumentBuilder extends AbstractFormBuilder
{
    const TITLE = 'title';
    const BODY = 'body';

    /**
     * @return Form
     */
    public function initializeForm(): Form
    {
        $this->form->addElement(self::TITLE, [
            new Required()
        ], [
            new TrimString(),
            new HtmlEntities()
        ]);
        $this->form->addElement(self::BODY, [
            new Required()
        ], [
            new TrimString(),
            new HtmlEntities()
        ]);
        return $this->form;
    }
}
