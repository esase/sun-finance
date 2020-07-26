<?php

namespace SunFinance\Module\Attachment\Form;

use SunFinance\Core\Form\AbstractFormBuilder;
use SunFinance\Core\Form\Form;
use SunFinance\Core\Form\Validator\FileMimeType;
use SunFinance\Core\Form\Validator\RequiredFile;

class AttachmentBuilder extends AbstractFormBuilder
{
    const FILE = 'file';

    /**
     * @return Form
     */
    public function initializeForm(): Form
    {
        $this->form->addElement(self::FILE, [
            new RequiredFile(),
            new FileMimeType([
                'application/pdf'
            ])
        ]);
        return $this->form;
    }
}
