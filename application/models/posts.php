<?php

class Posts extends _Mymodel
{
    function __construct()
    {
        parent::__construct();
        $this->setTable('post', 'postid');
    }
}
?>
