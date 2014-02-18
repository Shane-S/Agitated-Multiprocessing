<?php

/**
 * Our homepage.
 * 
 * controllers/welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Welcome extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  The normal pages
    //-------------------------------------------------------------

    function index() {
        $this->data['title'] = 'My Wonderful Webapp';
        $this->data['pagebody'] = 'welcome';
        $this->render();
    }

}

/* End of file welcome.php */
/* Location: application/controllers/welcome.php */