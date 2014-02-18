<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * Users table.
 *
 * @author		JLP
 * ------------------------------------------------------------------------
 */
class Users extends _Mymodel {

    // Constructor
    function __construct() {
        parent::__construct();
        $this->setTable('site_user', 'username');
    }

}

/* End of file users.php */
/* Location: application/models/users.php */