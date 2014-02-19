<?php

class Blog extends Application {

    const POST_CUTOFF = 300; // Number of characters before cutting off a post

    function __construct() {
        parent::__construct();
        $this->load->model('posts');
        $this->load->model('media');
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
        $posts = $this->posts->getAll_array();
        $parsable_posts = array('blog_posts' => &$posts);
        foreach($posts as &$post)
        {
            $post['post_content'] = strlen($post['post_content']) > self::POST_CUTOFF ? 
                    array_slice($post['post_content'], 0, self::POST_CUTOFF - 3) . '...' :
                    $post['post_content'];
            $post['thumb'] = '/data/images/' . $post['thumb'];
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
        $post = $this->posts->get_array($postid);
        $imgs = $this->media->querySomeMore('thumbnail', $post['thumb']);
        $post['full_size'] = '/data/images/' . $imgs[0]['filename'];
        
        return $this->parser->parse('_single_post', $post, true);
    }
}
