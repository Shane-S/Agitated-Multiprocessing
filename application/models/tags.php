<?php

class Tags extends _Mymodel
{
    function __construct()
    {
        parent::__construct();
        $this->setTable('tag', 'tagid');
    }
}
?>
