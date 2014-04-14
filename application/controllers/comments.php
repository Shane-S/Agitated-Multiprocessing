<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of comments
 *
 * @author Shane
 */
class Comments extends Application {

    function __construct() {
        parent::__construct();
        $this->restrict(array(ROLE_USER, ROLE_ADMIN));
        $this->load->model('posts');
        $this->load->model('comment');
    }
    
    /**
     * Adds a comment to the database that corresponds to this post.
     * 
     * @param int $postid The ID of the post corresponding to this comment.
     * @return void
     */
    function add($postid)
    {
        $newComment = $this->comment->create();
        $content  = $_POST['content'];
        $username = $this->session->userdata('username');
        if(empty($content))
        {
            redirect("/blog/post/$postid");
            return;
        }
        
        $newComment->comment_content = htmlentities($content);
        $newComment->username = $username;
        $newComment->postid = $postid;

        $this->comment->add($newComment);
        redirect("/blog/posts/$postid");
    }
}

