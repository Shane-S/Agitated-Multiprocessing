<?php

class Blog extends Application {

    const POST_CUTOFF = 300; // Number of characters before cutting off a post
    
    function __construct() {
        parent::__construct();
        $this->load->model('posts');
        $this->load->model('pages');
        $this->load->model('media');
        $this->load->model('tags');
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
                    str_split($post['post_content'], self::POST_CUTOFF - 3) . '...' :
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
        $tags = $this->tags->getAll_array();
        while (count($this->tags->getAll_array()) > $counter) {
            $tag = $this->posts->get_array($counter);
            if($tag['postid'] == $postid) {
                $tags = $this->tags->get_array($tag['postid']);
            }
            $counter++;
        }
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
    
    function pages($pageid)
    {
        
        $recent_posts = $this->_build_3_posts($pageid);
        $current_page = $this->getCurrentPage($pageid);
        $this->data['title']        = 'Home';
        $this->data['recent_posts'] = $recent_posts;
        $this->data['current_page'] = $current_page;
        
        $this->data['pagebody'] = 'homeView';
        $this->render();
    }
    
 
    /*
     * Builds the HTML for a list of the last 3 most recent posts.
     * 
     * The function sorts the post array by creation time, then limits the post 
     * count to the last 3 posts. It builds an array with their information,
     * which the template parser processes into HTML.
     * 
     * @return The HTML for displaying the three most recently created posts.
     */
    function _build_3_posts($pageid)
    {
        $recent_posts = $this->pages->nextThreePosts($pageid);
        
        foreach($recent_posts as &$recent_post)
            $recent_post['thumb'] = $recent_post['thumb'] ? '/data/thumbs/' . $recent_post['thumb'] : '';
        
        $parsable_recent['blog_posts'] = $recent_posts;
        return $this->parser->parse('_all_posts', $parsable_recent, true);
    }

    function getCurrentPage($pageid) {
        $allpages = (count($this->posts->getAll_array())) / 3;
        $page = $this->pages->get_array($pageid);
        if($pageid == 0) {
           $page['previous_button']       = makeLinkButton('Previous', '{previd}', 'Go to previous page', 'btn-blue btn-spaced', TRUE);
        } else {
            $page['previous_button']       = makeLinkButton('Previous', '{previd}', 'Go to previous page', 'btn-blue btn-spaced', FALSE);
        }
        if($allpages > $pageid) {
            $page['next_button']           = makeLinkButton('Next', '{nextid}', 'Go to next page','btn-blue btn-spaced', FALSE);
        } else {
            $page['next_button']           = makeLinkButton('Next', '{nextid}', 'Go to next page','btn-blue btn-spaced', TRUE);
        }
        $page['previd'] = $pageid - 1;
        $page['nextid'] = $pageid + 1;
        return $this->parser->parse('_single_page', $page, true);
    }
}
