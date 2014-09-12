<?php

class Media extends _Mymodel
{
    function __construct()
    {
        parent::__construct();
        $this->setTable('media', 'uid');
    }
}

