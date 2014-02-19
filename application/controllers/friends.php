<?php

class Friends extends Application {
    function __construct()
    {
        parent::__construct();
        $this->load->model('contacts');
    }
    
    function index()
    {
        $this->data['pagebody'] = "friends_list";
        $this->data['contacts'] = $this->contacts->getAll_array();
        $this->render();
    }
}

