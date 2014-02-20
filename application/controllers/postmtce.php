<?php

class Postmtce extends Application
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('posts');
    }
    
    function index()
    {
        $all_posts = array();
        $all_posts['posts'] = $this->posts->getAll_array();
        $this->data['title'] = 'Post Maintenance';
        $this->data['post_mtce_content'] = $this->parser->parse('_post_edit_list', $all_posts, true);
        $this->data['pagebody'] = 'postMtceView';
        $this->render();
    }
    
    function edit($postid)
    {
        $post = $this->posts->get_array($postid);
        $post_title = $post['title'];
        $this->data['title'] = "Edit Post: $post_title"; 
        $this->data['post_mtce_content'] = $this->parser->parse('_post_edit_list', $post, true);
        $this->data['pagebody'] = 'postMtceView';
        $this->data['postid'] = $postid;
        $this->render();
    }

    function add()
    {
        $post = array('title' => 'new',
                        'post_content' => '');
        $this->data['title'] = "New Post";
        $this->data['postid'] = 'new';
        $this->data['post_mtce_content'] = $this->parser->parse('_post_edit_single', $post, true);
        $this->data['pagebody'] = 'postMtceView';
        $this->render();
    }
    
    /*
     * Submits data from an add or edit user form.
     * 
     * @param postid The id of the post of which we want the author.
     * @return An array containi
     */
    function submit($postid = null)
    {
        // either create or retrieve the relevant user record
        if ($postid == null || $postid == 'new')
            $post = $this->posts->create();
        else
            $post = $this->posts->get($postid);

        // over-ride the user record fields with submitted values
        $post->title = $_POST['title'];
        $post->content = $_POST['post_content'];

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
            $this->data['post_mtce_content'] = (array)$user;
            $this->data['pagebody'] = 'userMtceView';
            $this->render();
            exit;
        }

        // Set the last modified time and the user who did the modification
        $post->modified_at = date('Y-m-d H:i:s');
        $post->modified_by = $this->session->get_userdata('username');

        // either add or update the post record, as appropriate
        if ($postid == null || $postid=='new')
            $this->posts->add($postid);
        else
            $this->posts->update($postid);

        // redisplay the list of users
        redirect('postmtce');
    }

     // Delete a user
    function delete($postid)
    {
        $this->posts->delete($postid);
        redirect('postmtce');
    }
}
?>
