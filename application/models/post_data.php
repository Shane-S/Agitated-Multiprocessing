<?php

class Post_Data extends CI_Model {

// Constructor
    var $posts;
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->_build_posts();
    }

    /*
     * Builds the posts array from the database.
     * 
     * Selects all rows from the posts table and builds a the array; $this->posts[$postid]
     * contains the information about a particular post.
     * 
     * @return Returns void.
     */
    private function _build_posts()
    {
	$query = $this->db->query('SELECT * FROM post');
	$this->posts = array();

	foreach($query->result_array() as $row)
		$this->posts[$row['postid']] = $row;
    }

    /*
     * Returns the posts array.
     */
    function get_all_posts()
    {
        return $this->posts;
    }
    
    /*
     * Returns a single post with the specified post id.
     */
    function get_post($postid)
    {
        return $this->posts[$postid];
    }

    /*
     * Gets the image (not the thumbnail) associated with a particular post by
     * selecting the matching thumbnail from the media table.
     * 
     * @return This post's image's file name.
     */
    function get_image($postid)
    {
        $thumbnail = $this->posts[$postid]['thumb'];
        $query = $this->db->query("SELECT `filename` FROM `media` WHERE `thumbnail` = '$thumbnail'");
        $row = $query->row();
        return $row->filename;
    }
    
    /*
     * Gets the category associated with a particular post. This will likely
     * be changed in a later lab or assignment.
     * 
     * @param postid The id of the post for which we want a category.
     * @return The category associated with a post.
     */
    function get_cat($postid)
    {
        $query = $this->db->query("SELECT `name` FROM `category` WHERE `catid` = '$this->posts[$postid]['catid']'");
        $row = $query->row();
        return $row->name;
    }
    
    /*
     * Gets the post author's first and last names.
     * 
     * @param postid The id of the post of which we want the author.
     * @return An array containi
     */
    function get_author($postid)
    {
        $username = $this->posts[$postid]['username'];
        $query = $this->db->query("SELECT `lastname`, `firstname` FROM `site_user` WHERE `username` = '$username'");
        $row = $query->row();
        $author = array('firstname' => $row->firstname, 'lastname' => $row->lastname);

        return $author;
    }
    
    

}
