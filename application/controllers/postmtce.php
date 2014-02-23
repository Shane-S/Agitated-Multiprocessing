<?php

class Postmtce extends Application
{
    function __construct()
    {
        parent::__construct();
        $this->restrict(ROLE_USER);
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
        $this->data['post_mtce_content'] = $this->parser->parse('_post_edit_single', $post, true);
        $this->data['pagebody'] = 'postMtceView';
        $this->render();
    }

    function add()
    {
        $post = array('postid' => 'new',
                        'title' => '',
                        'post_content' => '');
        $this->data['title'] = "New Post";
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
        $post->post_content = $_POST['post_content'];

        // Set the last modified time and the user who did the modification
        $post->updated_at = date('Y-m-d H:i:s');
        $post->modified_by = $this->session->userdata('username');

        // either add or update the post record, as appropriate
        if ($postid == null || $postid=='new')
        {
            $post->username = $this->session->userdata('username');
            $post->created_at = $post->updated_at;
            $this->posts->add($post);
        }
        else
            $this->posts->update($post);

        // redisplay the list of posts
        redirect('/postmtce');
    }

     // Delete a post
    function delete($postid)
    {
        $this->posts->delete($postid);
        redirect('/postmtce');
    }
}
