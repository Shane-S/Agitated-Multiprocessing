<?php

class Blog extends Application {

    const POST_CUTOFF = 300; // Number of characters before cutting off a post

    function __construct() {
        parent::__construct();
        $this->load->model('post_data');
    }

    /*
     * Displays an abbreviated version of each post, displaying thumbnail
     * and part of the post.
     * 
     * @return void
     */
    function index()
    {
        $this->data['title'] = 'Blog';
        $this->data['blog_content'] = $this->_build_allposts();
        $this->data['pagebody'] = 'blogView';
        $this->render();
    }
    
    /*
     * Displays a single post, including its full-size image and all content.
     * 
     * @param postid ID of the post to display.
     * @return void
     */
    function posts($postid)
    {
        $this->data['title'] = 'Blog';
        $this->data['blog_content'] = $this->_build_singlepost($postid);
        $this->data['pagebody'] = 'blogView';
        $this->render();
    }
    
    /*
     * Builds the HTML to display all posts (in the index() function).
     * 
     * First, the function obtains the list of posts from the model. It then
     * processes each and adds its information to an array to be parsed by the
     * template parser.
     * 
     * @return The HTML for displaying all posts.
     */
    function _build_allposts()
    {
        $posts = $this->post_data->get_all_posts();
        $parsable_posts = array('blog_posts' => array());
        foreach($posts as $post)
        {
            $trunc_content = (strlen($post['content']) > self::POST_CUTOFF) ? array_slice($post['content'], 0, POST_CUTOFF - 3) . '...'
                    : $post['content'];
            $author = $this->post_data->get_author($post['postid']);

            $parsable_posts['blog_posts'][] = array(
                'postid' => $post['postid'],
                'thumb' => '/data/images/' . $post['thumb'],
                'title' => $post['title'],
                'trunc_content' => $trunc_content, 
                'author_first' => $author['firstname'], 
                'author_last' => $author['lastname'],
                'updated_at' => $post['updated_at']);
        }
        
        return $this->parser->parse('_all_posts', $parsable_posts, true);
    }
    
    /*
     * Builds the HTML for displaying a single post with id $postid.
     * 
     * The function obtains the specified post's details using a model accessor
     * method, then processes the information and places it in an array to be parsed
     * by the template parser.
     * 
     * @return The HTML for displaying a single post.
     */
    function _build_singlepost($postid)
    {
        $post = $this->post_data->get_post($postid);
        $full_size_img = $this->post_data->get_image($postid);
        $author = $this->post_data->get_author($postid);

        $parsable_post = array(
            'title' => $post['title'],
            'author_first' => $author['firstname'],
            'author_last' => $author['lastname'],
            'full_size' => '/data/images/' . $full_size_img,
            'content' => $post['content'],
            'created_at' => $post['created_at'],
            'updated_at' => $post['updated_at']);
        
        return $this->parser->parse('_single_post', $parsable_post, true);
    }
}
