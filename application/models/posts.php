<?php

class Posts extends _Mymodel
{
    function __construct()
    {
        parent::__construct();
        $this->setTable('post', 'postid');
    }
    
    function recent()
    {
        $parsable_recent = array();
        $posts = $this->posts->getAll_array();
        $times = array();

        foreach($posts as $post)
            $times[$post['postid']] = strtotime($post['created_at']);
        
        array_multisort($times, SORT_DESC, $posts);
        $recent_posts   = array_slice($posts, 0, 3);
        return $recent_posts;
    }
}
