<?php

class UserMtce extends Application
{
    function __construct()
    {
        parent::__construct();
        //$this->restrict(ROLE_ADMIN);
        $this->load->model('users');
    }
    
    function index()
    {
        $all_users = array();
        $all_users['users'] = $this->users->getAll_array();
        $this->data['title'] = 'User Maintenance';
        $this->data['user_mtce_content'] = $this->parser->parse('_user_list', $all_users, true);
        $this->data['pagebody'] = 'userMtceView';
        $this->render();
    }
    
    function edit($username)
    {
        $user = $this->users->get_array($username);
        $user['password'] = '';
        $this->data['title'] = "Edit User: $username";
        $this->data['user_mtce_content'] = $this->parser->parse('_user_edit', $user, true);
        $this->data['pagebody'] = 'userMtceView';
        $this->data['username'] = $username;
        $this->render();
    }

    function add()
    {
        $user = array('username' => 'new',
                        'firstname' => '',
                        'lastname' => '',
                        'email' => '',
                        'created_at'=>'',
                        'password' => '',
                        'role' => '');
        $this->data['title'] = "Add User";
        $this->data['id'] = 'new';
        $this->data['user_mtce_content'] = $this->parser->parse('_user_edit', $user, true);
        $this->data['pagebody'] = 'userMtceView';
        $this->render();
    }
    
    /*
     * Submits data from an add or edit user form.
     * 
     * @param postid The id of the post of which we want the author.
     * @return An array containi
     */
    function submit($username = null)
    {
        // the form fields we are interested in
        $user_fields = array('username', 'email', 'role', 'firstname', 'lastname');

        // either create or retrieve the relevant user record
        if ($username == null || $username == 'new')
            $user = $this->users->create();
        else
            $user = $this->users->get($username);

        // over-ride the user record fields with submitted values
        fieldExtract($_POST, $user, $user_fields);
        $this->data['errors'] = array();
        // validate the user fields
        if ($_POST['username'] == 'new' || empty($_POST['username']))
            $this->data['errors'][] = 'You need to specify a userid';
        else if ($username != 'new' && $username != null && $username != $_POST['username'])
            $this->data['errors'][] = 'User names may not be changed.';
        if ($username == null && $this->users->exists($_POST['username']))
            $this->data['errors'][] = 'That username is already in use; please choose another.';
        if (strlen($user->username) < 1)
            $this->data['errors'][] = 'You need a user name';
        else if(strlen ($user->username) > 40)
            $this->data['errors'][] = 'User names must be 40 characters or less.';
        if (strlen($user->email) < 1)
            $this->data['errors'][] = 'You need an email address';
        if (!strpos($user->email, '@'))
            $this->data['errors'][] = 'The email address is missing the domain';
        if ($username == null && empty($user->password))
            $this->data['errors'][] = 'You must specify a password';

        // if errors, redisplay the form
        if (count($this->data['errors']) > 0) {
            // over-ride the view parameters to reflect our data
            $this->data['user_mtce_content'] = (array)$user;
            $this->data['pagebody'] = 'userMtceView';
            $this->render();
            exit;
        }

        // handle the password specially, as it needs to be encrypted
        $new_password = $_POST['password'];
        if (!empty($new_password)) {
            $new_password = md5($new_password);
            if ($new_password != $user->password)
                $user->password = $new_password;
        }

        if($username == null || $username=='new')
            $user->created_at = date('Y-m-d H:i:s');

        // either add or update the user record, as appropriate

        if ($username == null || $username=='new') {
            $user->username = $_POST['username'];
            $this->users->add($user);
        }
        else
            $this->users->update($user);

        // redisplay the list of users
        redirect('usermtce');
    }

     // Delete a user
    function delete($id)
    {
        $this->users->delete($id);
        redirect('usermtce');
    }
}
