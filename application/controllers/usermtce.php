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
        $roles_label        = makeLabel('roles', 'Roles');
        $firstname_label    = makeLabel('firstname', 'First Name');
        $lastname_label     = makeLabel('lasname', 'Last Name');
        $email_label        = makeLabel('email', 'Email');
        $submit_button      = makeSubmit('Submit');
        $cancel_button      = makeButton('Cancel');
        $user_edit_form     = array();
        $user               = $this->users->get_array($username);
        
        /* Set up the view template parameters */
        $user_edit_form['username']         = $username;
        $user_edit_form['username_input']   = makeLabel('username', 'Username: ' . $username);
        $user_edit_form['password_input']   = '';
        $user_edit_form['roles_input']      = makeComboField($roles_label, 'role', $this->roles->getAll_array(), 25);
        $user_edit_form['firstname_input']  = makeTextField($firstname_label, 'firstname', 'text', $user['firstname'], 40);
        $user_edit_form['lastname_input']   = makeTextField($lastname_label, 'lastname', 'text', $user['lastname'], 40);
        $user_edit_form['email_input']      = makeTextField($email_label, 'email', 'text', $user['email'], 40);
        $user_edit_form['actions']          = $submit_button . $cancel_button;
        

        $this->data['title'] = "Edit User: $username";
        $this->data['user_mtce_content'] = $this->parser->parse('_user_edit', $user_edit_form, true);
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
