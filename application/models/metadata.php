<?php

class MetaData extends _Mymodel
{
    function __construct() {
        parent::__construct();
        $this->setTable('metadata', 'property');
    }
}
