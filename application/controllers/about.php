<?php

/**
 * Our homepage.
 * 
 * controllers/welcome.php
 *
 * ------------------------------------------------------------------------
 */
class About extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->data['title'] = 'About';
        $this->data['pagebody'] = 'aboutView';
        $this->render();
    }

}

/* End of file welcome.php */
/* Location: application/controllers/welcome.php */