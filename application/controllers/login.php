<?php

/**
 * controllers/login.php
 *
 * Login manager 
 *
 * @package		Java-Geeks
 * @author		JLP
 * @copyright           Copyright (c) 2010-2013, J.L. Parry
 * @since		Version 2.0.0
 * ------------------------------------------------------------------------
 */
class Login extends Application {

    function __construct() {
        
        parent::__construct();
        $this->load->model('users');
    }

    //-------------------------------------------------------------
    //  Default entry point. 
    //  We should never get here, since the login form is in the sidebar
    //-------------------------------------------------------------

    function index() {
        $this->data['pagebody'] = 'loginView';
        $this->render();
        
        if(isset($_POST['username']) && isset($_POST['password'])) {
            $key = $_POST['username'];
            $password = md5($_POST['password']);

            $user = $this->users->get($key);
            if ($user == null) {
                echo 'No such user<br/>';
                redirect('/');
            }
            //check the password
            if ($password == (string) $user->password) {
            // we have a winner!
                $this->session->set_userdata('username', $key);
                $this->session->set_userdata('role', $user->role);
                redirect("/");
                return;
            } else {
                   echo 'Password does not match<br/>';
                   redirect("/");
            }
            $this->data['pagebody'] = 'loginview';
            $this->render();
        }
    }
    
    // Process a login
    function submit() {
        $key = $_POST['username'];
        $password = md5($_POST['password']);
//        echo 'key: '.$key.'<br/>';
//        echo 'password: '.$password.'<br/>';
//        exit;
       
       $user = $this->users->get($key);
       
         // what if no such user
        if ($user == null) {
        echo 'No such user<br/>';
            redirect('/');
        }
        //check the password
        if ($password == (string) $user->password) {
            // we have a winner!
            $this->session->set_userdata('username', $key);
            $this->session->set_userdata('role', $user->role);
            redirect("/");
        } else {
            echo 'Password does not match<br/>';
            redirect("/");
        }
    }
    
}

/* End of file login.php */
/* Location: application/controllers/login.php */