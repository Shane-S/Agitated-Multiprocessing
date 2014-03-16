<?php

class UserMtce extends Application
{
    const VALID_INPUT       = 0;
    const EMPTY_FIELD       = 1;
    const ALREADY_IN_USE    = 2;
    const BAD_EXTENSION     = 3;

    /**
     * Loads the necessary database models to accommodate user maintenance.
     */
    function __construct()
    {
        parent::__construct();
        $this->restrict(ROLE_ADMIN);
        $this->load->model('users');
        $this->load->model('roles');
    }
    
    /**
     * Populates the default view of the user edit page.
     */
    function index()
    {
        $all_users = array();
        $all_users['users'] = $this->users->getAll_array();
        $this->data['title'] = 'User Maintenance';
        $this->data['user_mtce_content'] = $this->parser->parse('_user_list', $all_users, true);
        $this->data['pagebody'] = 'userMtceView';
        $this->render();
    }
    
    /**
     * Edit the user with the specified username.
     * 
     * @param type $username The username of the user to edit.
     */
    function edit($username)
    {
        $this->edit_user($username);
    }

    /**
     * Add a new user.
     */    
    function add()
    {
        $this->edit_user(null);
    }
    
    /**
     * Sets up the view with the relevant information. 
     * 
     * This is the private backend to the edit and add functions; they do pretty
     * much exactly the same thing, so they can be handled by one function.
     * 
     * @param string $username Name of the user to edit (null if creating a user).
     */
    private function edit_user($username = null)
    {
        $roles_label        = makeLabel('roles', 'Roles');
        $firstname_label    = makeLabel('firstname', 'First Name');
        $lastname_label     = makeLabel('lasname', 'Last Name');
        $username_label     = makeLabel('username', 'Username');
        $email_label        = makeLabel('email', 'Email');
        $password_label     = makeLabel('password', 'Password');
        $password_explain   = makeDescription('Enter if changed');
        $submit_button      = makeSubmit('Submit', 'btn-blue btn-spaced');
        $cancel_button      = makeButton('Cancel', 'btn-blue btn-spaced');
                
        $user_edit_form['username_input']   = $username ? '' : makeTextField($username_label, 'username', 'text', '', 40, 40);
        $user_edit_form['password_input']   = makeTextField($password_label, 'password', 'text', '', 40, 40, $password_explain);
        $user_edit_form['roles_input']      = makeComboField($roles_label, 'role', $this->_build_roles(), 25);
        $user_edit_form['firstname_input']  = makeTextField($firstname_label, 'firstname', 'text', '', 40);
        $user_edit_form['lastname_input']   = makeTextField($lastname_label, 'lastname', 'text', '', 40);
        $user_edit_form['email_input']      = makeTextField($email_label, 'email', 'text', '', 40);
        $user_edit_form['actions']          = makeParagraph($submit_button . $cancel_button);
        
        $this->data['title'] = $username ? "Edit User: $username" : "Add User";
        $this->data['username'] = $username? $username : 'new';
        $this->data['user_mtce_content'] = $this->parser->parse('_user_edit', $user_edit_form, true);
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
        {
            $user['username'] = $username; // Just in case someone decided to do some JavaScript injection
            $this->users->update($user);
        }

        // redisplay the list of users
        redirect('usermtce');
    }

    function validate($what, $value, $echo = true)
    {
        if(!$value)
            return false;
        
        else if($this->users->countWhich($what, $value) > 0)
            echo false;
        else
            echo true;
    }
    
    /**
     * Gets a list of roles available to users and to populate the combo box.
     * 
     * @return array Array of all user roles.
     */
    private function _build_roles()
    {
        $role_options       = array();
        foreach($this->roles->getAll_array() as $role_arr)
            $role_options[] = array('option' => $role_arr['role']);
        
        return $role_options;
    }
    
     // Delete a user
    function delete($username)
    {
        $this->users->delete($username);
        redirect('usermtce');
    }
}
