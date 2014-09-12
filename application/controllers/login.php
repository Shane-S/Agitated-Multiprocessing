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

    function index()
    {
        if(isset($_POST['username']) && isset($_POST['password'])) {
            $key = $_POST['username'];
            $password = md5($_POST['password']);

            $user = $this->users->get($key);
            if ($user == null) {
                redirect('/login');
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
                   redirect("/login");
            }
        }
        else
        {
            $this->_build_login();
            $this->data['title'] = 'Login';
            $this->data['pagebody'] = 'loginView';
            $this->render();
        }
    }
    
    function _build_login()
    {
        $user_label = makeLabel('username', 'Username');
        $pass_label = makeLabel('password', 'Password');
        $this->data['username'] = makeTextField($user_label, 'username', 'text', '', 25);
        $this->data['password'] = makeTextField($pass_label, 'password', 'password', '', 25);
        $this->data['submit'] = makeSubmit('Login');
    }
    
    // Process a login
    function submit() {
        $key = $_POST['username'];
        $password = md5($_POST['password']);
       
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