<?php

/**
 * controllers/login.php
 *
 * Logout manager 
 *
 * @package		Java-Geeks
 * @author		JLP
 * @copyright           Copyright (c) 2010-2013, J.L. Parry
 * @since		Version 2.0.0
 * ------------------------------------------------------------------------
 */
class Logout extends Application {

    function __construct() {
        parent::__construct();
    }

    //-------------------------------------------------------------
    //  bye bye
    //-------------------------------------------------------------

    function index() {
        $this->session->sess_destroy();
        redirect('/');
    }

}

/* End of file logout.php */
/* Location: application/controllers/logout.php */