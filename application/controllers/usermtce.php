<?php

class UserMtce extends Application
{
    function __construct()
    {
        parent::__construct();
        $this->restrict(ROLE_ADMIN);
        $this->load->model('users');
        $this->load->model('roles');
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
        $roles = array();
        $user = $this->users->get_array($username);
        
        $user['password'] = '';
        unset($user['role']);
        $user['roles'] = $this->roles->getAll_array();
        $this->data['title'] = "Edit User: $username";
        $this->data['user_mtce_content'] = $this->parser->parse('_user_edit', $user, true);
        $this->data['pagebody'] = 'userMtceView';
        $this->data['username'] = $username;
        $this->render();
    }

    function add()
    {
        $roles = array();
        $user = array('username' => '',
                        'firstname' => '',
                        'lastname' => '',
                        'email' => '',
                        'created_at'=>'',
                        'password' => '',
                        'roles' => $this->roles->getAll_array());
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
