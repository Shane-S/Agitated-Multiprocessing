<?php

class Contacts extends _Mymodel {

// Constructor
    function __construct() {
        parent::__construct();
        $this->setTable('contacts', 'id');
    }
}
