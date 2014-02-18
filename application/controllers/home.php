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
        $this->load->model('post_data');
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
        $parsable_recent = array('recent_posts' => array());
        $posts = $this->post_data->get_all_posts();
        $times = array();

        foreach($posts as $postid => $post)
            $times[$postid] = strtotime($posts[$postid]['created_at']);
        
        array_multisort($times, SORT_DESC, $posts);
        $recent_posts = array_slice($posts, 0, 3);

        foreach($recent_posts as $recent_post)
        {
            $thumb = '/data/images/' . $recent_post['thumb'];
            $author = $this->post_data->get_author($recent_post['postid']);

            $parsable_recent['recent_posts'][] = array(
                'postid' => $recent_post['postid'],
                'thumb' => $thumb, 
                'title' => $recent_post['title'], 
                'author_first' => $author['firstname'], 
                'author_last' => $author['lastname'], 
                'modified' => $recent_post['created_at']);
        }
        return $this->parser->parse('_recent_posts', $parsable_recent, true);
    }

}

/* End of file welcome.php */
/* Location: application/controllers/welcome.php */