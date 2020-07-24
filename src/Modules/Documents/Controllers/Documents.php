<?php

namespace SunFinance\Modules\Documents\Controllers;

use SunFinance\Core\Http\Request;

class Documents
{

    /**
     * @var Request
     */
    private $request;

    /**
     * Documents constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function list()
    {
        return [
            [
                'name' => 'a'
            ]
        ];
    }

    public function view()
    {
        return $this->request->getUriParam('id');
    }

}

