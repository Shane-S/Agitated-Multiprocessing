<?php

/**
 * Our homepage.
 * 
 * controllers/welcome.php
 *
 * ------------------------------------------------------------------------
 */
class Home extends Application {

    function __construct() {
        parent::__construct();
        $this->load->model('posts');
    }

    /*
     * Renders the page with the content built in _build_recent_posts.
     * 
     * @return void
     */
    function index() {
        $recent_posts = $this->_build_recent_posts();

        $this->data['title']        = 'Home';
        $this->data['recent_posts'] = $recent_posts;
        $this->data['pagebody']     = 'homeView';
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
    function _build_recent_posts()
    {
        $parsable_recent = array();
        $posts = $this->posts->getAll_array();
        $times = array();

        foreach($posts as $post)
            $times[$post['postid']] = strtotime($post['created_at']);
        
        array_multisort($times, SORT_DESC, $posts);
        $recent_posts = array_slice($posts, 0, 3);

        foreach($recent_posts as &$recent_post)
            $recent_post['thumb'] = '/data/images/' . $recent_post['thumb'];

        $parsable_recent['blog_posts'] = $recent_posts;
        return $this->parser->parse('_all_posts', $parsable_recent, true);
    }

}

/* End of file welcome.php */
/* Location: application/controllers/welcome.php */