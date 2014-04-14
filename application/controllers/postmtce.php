<?php

class Postmtce extends Application
{
    /**
     * Restricts the page to the administrator role.
     */
    function __construct()
    {
        parent::__construct();
        $this->restrict(array(ROLE_ADMIN));
        $this->load->model('posts');
        $this->load->model('media');
        $this->load->model('metadata');
        $this->load->library('xmlrpc');
    }
    
    /**
     * Displays a the list of all posts with edit/delete controls and the facility
     * to add new posts.
     */
    function index()
    {
        $all_posts = array();
        $all_posts['posts'] = $this->posts->getAll_array();
        $this->data['title'] = 'Post Maintenance';
        $this->data['post_mtce_content'] = $this->parser->parse('_post_edit_list', $all_posts, true);
        $this->data['pagebody'] = 'postMtceView';
        $this->render();
    }

    /**
     * Displays the post for editing and allows the user to change various properties (the image,
     * the post title, the post content, and the creation date).
     * 
     * @param type $postid ID of the post to edit.
     */
    function edit($postid)
    {
        $post = $this->posts->get_array($postid);
        $post['text_editor']    = makeTextEditor(makeLabel('post_content', 'Body'), 'post_content', $post['post_content'], '10em');
        $post['date_picker']    = makeDateSelector(makeLabel('created_at', 'Creation Date:'), 'created_at', 
                                                              date_create_from_format('Y-m-d H:i:s', $post['created_at'])->format('Y-m-d'));
        $post['post_title']     = makeTextfield(makeLabel('post_title', 'Title:'), 'post_title', 'text', $post['title'], 40);
        $post['slug']           = makeTextfield(makeLabel('slug', 'Slug:'), 'slug', 'text', $post['slug'], 40, 150);
        $post['image_upload']   = makeImageUploader(makeLabel('post_image', 'Post Image:'), 'post_image');
        $this->data['title'] = 'Edit Post: ' . $post['title']; 
        $this->data['post_mtce_content'] = $this->parser->parse('_post_edit_single', $post, true);
        $this->data['pagebody'] = 'postMtceView';
        $this->render();
    }

    /**
     * Allows the user to add a new post (specifying the image, title, slug, content, and creation date).
     */
    function add()
    {
        $post = array('postid' => 'new',
                        'post_title' => makeTextField(makeLabel('post_title', 'Title:'), 'post_title', 'text', '', 40),
                        'post_content' => '',
                        'slug' => makeTextField(makeLabel('slug', 'Slug:'), 'slug', 'text', '', 40, 150),
                        'text_editor' => makeTextEditor(makeLabel('post_content', 'Post body'), 'post_content', '', '10em'),
                        'date_picker' => makeDateSelector(makeLabel('created_at', 'Post creation date:'), 'created_at', ''),
                        'image_upload' => makeImageUploader(makeLabel('post_image', 'Post Image:'), 'post_image'));
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
        $stored_date = date_create_from_format('Y-m-d H:i:s', $post->created_at);

        if(!$input_date || $input_date == '' || ($stored_date && $_POST['created_at'] == $stored_date->format('Y-m-d'))) // No date or unchanged
        {
            $post->updated_at = date('Y-m-d H:i:s');
            $post->created_at = ($postid == null || $postid == 'new') ? $post->updated_at : $post->created_at;
        }
        else
        {
            $post->created_at = $input_date->format('Y-m-d H:i:s');
            $post->updated_at = $post->created_at;
        }

        if(!empty($_FILES['post_image']['name']) && !file_exists('/data/images' . $_FILES['post_image']['name']))
        {
            $thumb_marker = '_thumb';
            $dot_idx = strrpos($_FILES['post_image']['name'], '.', -1);
            $thumb_name = substr($_FILES['post_image']['name'], 0, $dot_idx) 
                          . $thumb_marker 
                          . substr($_FILES['post_image']['name'], $dot_idx);
            $file_path = DATA_FOLDER . '/images/' . $_FILES['post_image']['name'];
            $media_entry = array('filename' => $_FILES['post_image']['name'],
                                 'author' => '',
                                 'modified' => '',
                                 'thumbnail' => $thumb_name,
                                 'uid' => '');

            move_uploaded_file($_FILES['post_image']['tmp_name'], 
                               DATA_FOLDER . '/images/' . $_FILES['post_image']['name']);

            $config = array('source_image' =>$file_path,
                'new_image' => DATA_FOLDER . '/thumbs/',
                'width' => '300',
                'height' => '300',
                'create_thumb' => true,
                'thumb_marker' => $thumb_marker);
            $this->load->library('image_lib', $config);
            if(!$this->image_lib->resize())
               echo $this->image_lib->display_errors();

            $post->thumb = $thumb_name;
            $this->media->add($media_entry);
        }
        
        // either add or update the post record, as appropriate
        if ($postid == null || $postid=='new')
        {
            $post->username = $this->session->userdata('username');
            $this->posts->add($post);
            $this->syndicate_post($post);
        }
        else
            $this->posts->update($post);

        // redisplay the list of posts
        redirect('/home');
    }

    /**
     * Allows the user to delete a post.
     * 
     * @param type $postid The post to delete.
     */
    function delete($postid)
    {
        $this->posts->delete($postid);
        redirect('/postmtce');
    }
    
    /**
     * Sends a new post to the syndication server.
     * 
     * @param object $post The post to be sent.
     */
    function syndicate_post($post)
    {
        $this->xmlrpc->server('http://showcase.bcitxml.com/boss', 80);
        $this->xmlrpc->method('newpost');
        $request = array(
                            array($this->metadata->get('syndication_code')->value, 'string'),
                            array($post->postid, 'int'),
                            array(date('Y-m-d-H-i', strtotime($post->created_at)), 'string'),
                            array($_SERVER['SERVER_NAME'] . '/blog/posts/' . $post->postid, 'string'),
                            array($post->title, 'string'),
                            array($post->slug, 'string')
                        );
        $this->xmlrpc->request($request);
        $this->xmlrpc->send_request($request);
    }
}
