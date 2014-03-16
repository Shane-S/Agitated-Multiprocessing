<?php

class SiteMtce extends Application
{
    function __construct() {
        parent::__construct();
        $this->restrict(ROLE_ADMIN);
        $this->load->model('metadata');
    }
    
    function index()
    {
        
    }
}

