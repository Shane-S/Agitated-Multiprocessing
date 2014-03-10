<?php

class Postmtce extends Application
{
    function __construct()
    {
        parent::__construct();
        $this->restrict(array(ROLE_USER, ROLE_ADMIN));
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
        $post['text_editor']    = makeTextEditor(makeLabel('post_content', 'Body'), 'post_content', $post['post_content'], '10em');
        $post['date_picker']    = makeDateSelector(makeLabel('created_at', 'Creation Date:'), 'created_at', 
                                                              date_create_from_format('Y-m-d H:i:s', $post['created_at'])->format('Y-m-d'));
        $post['post_title']     = makeTextfield(makeLabel('post_title', 'Title:'), 'post_title', 'text', $post['title'], 40);
        $post['slug']           = makeTextfield(makeLabel('slug', 'Slug:'), 'slug', 'text', $post['slug'], 40, 150);
        $this->data['title'] = 'Edit Post: ' . $post['title']; 
        $this->data['post_mtce_content'] = $this->parser->parse('_post_edit_single', $post, true);
        $this->data['pagebody'] = 'postMtceView';
        $this->render();
    }

    function add()
    {
        $post = array('postid' => 'new',
                        'post_title' => makeTextField(makeLabel('post_title', 'Title:'), 'post_title', 'text', '', 40),
                        'post_content' => '',
                        'slug' => makeTextField(makeLabel('slug', 'Slug:'), 'slug', 'text', '', 40, 150),
                        'text_editor' => makeTextEditor(makeLabel('post_content', 'Post body'), 'post_content', '', '10em'));
        $post['date_picker'] = makeDateSelector(makeLabel('created_at', 'Post creation date:'), 'created_at', '');
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
        $post->title = $_POST['post_title'];
        $post->post_content = $_POST['post_content'];

        // Set the last modified time and the user who did the modification
 
        $post->modified_by = $this->session->userdata('username');
        $post->slug = $_POST['slug'];
        $input_date = date_create_from_format('Y-m-d', $_POST['created_at']);
        $stored_date = date_create_from_format('Y-m-d H:i:s', $post->created_at)->format('Y-m-d');

        if(empty($_POST['created_at']) || $_POST['created_at'] == $stored_date)
        {
            $post->updated_at = date('Y-m-d H:i:s');
            $post->created_at = ($postid == null || $postid == 'new') ? $post->updated_at : $post->created_at;
        }
        else
        {
            $post->created_at = $input_date->format('Y-m-d H:i:s');
            $post->updated_at = $post->created_at;
        }
        
        // either add or update the post record, as appropriate
        if ($postid == null || $postid=='new')
        {
            $post->username = $this->session->userdata('username');
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
