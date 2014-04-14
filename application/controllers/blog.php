<?php

class Blog extends Application {

    const POST_CUTOFF = 300; // Number of characters before cutting off a post
    
    function __construct() {
        parent::__construct();
        $this->load->model('posts');
        $this->load->model('media');
        //$this->load->model('tags');
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
        foreach($posts as $post)
        {
            $post['post_content'] = strlen($post['post_content']) > self::POST_CUTOFF ? 
                    array_slice($post['post_content'], 0, self::POST_CUTOFF - 3) . '...' :
                    $post['post_content'];
            $post['thumb'] = $post['thumb'] ? '/data/thumbs/' . $post['thumb'] : '';
            
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
        $counter = 0;
        $allposts = count($this->posts->getAll_array());
        $post = $this->posts->get_array($postid);
        //$tags = $this->tags->getAll_array();
        //while (count($this->tags->getAll_array()) > $counter) {
        //    $tag = $this->posts->get_array($counter);
        //    if($tag['postid'] == $postid) {
        //        $tags = $this->tags->get_array($tag['postid']);
        //    }
        //    $counter++;
        //}
        $imgs = $this->media->querySomeMore('thumbnail', $post['thumb']);
        $post['full_size'] = $imgs ? '/data/images/' . $imgs[0]['filename'] : '';
        if($postid == 1) {
           $post['previous_button']       = makeLinkButton('Previous', '{previd}', 'Go to previous page', 'btn-blue btn-spaced', TRUE);
        } else {
            $post['previous_button']       = makeLinkButton('Previous', '{previd}', 'Go to previous page', 'btn-blue btn-spaced', FALSE);
        }
        if($allposts > $postid) {
            $post['next_button']           = makeLinkButton('Next', '{nextid}', 'Go to next page','btn-blue btn-spaced', FALSE);
        } else {
            $post['next_button']           = makeLinkButton('Next', '{nextid}', 'Go to next page','btn-blue btn-spaced', TRUE);
        }
        $post['previd'] = $postid - 1;
        $post['nextid'] = $postid + 1;
        
        return $this->parser->parse('_single_post', $post, true);
    }
    
    
}
