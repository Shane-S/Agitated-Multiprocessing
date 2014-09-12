<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of comments
 *
 * @author Shane
 */
class Comment extends _Mymodel{

    function __construct() {
        parent::__construct();
        $this->setTable('comment', 'comment_id');
    }
}

