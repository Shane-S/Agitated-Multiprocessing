<?php

class Capo extends CI_Controller
{

/**
 * Loads 
 */
function __construct() {
        parent::__construct();
        $this->load->library('xmlrpc');
        $this->load->library('xmlrpcs');
        $this->load->model('metadata');
        $this->load->model('posts');
    }

    // Entry point to the XML-RPC server
    function index() {
        // configure to accept either class.method or just method requests
        $config['functions']['capo.info']   = $config['functions']['info']   = array('function' => 'Capo.info');
        $config['functions']['capo.latest'] = $config['functions']['latest'] = array('function' => 'Capo.latest');
        $config['functions']['capo.posts']  = $config['functions']['posts']  = array('function' => 'Capo.posts');
        $config['functions']['capo.post']   = $config['functions']['post']   = array('function' => 'Capo.post');
        $config['object'] = $this;

        $this->xmlrpcs->initialize($config);
        $this->xmlrpcs->serve();
    }

    /**
     * Encapsulates the site info in a struct of structs for decapsulation by the
     * client.
     * 
     * @param xml-rpc $request
     * @return boolean Whether the send succeeded or failed.
     */
    function info($request = null) {
        // build our raw response. 
        $answer = array(
                'code' => array($this->metadata->get('syndication_code')->value, 'string'),
                'name' => array($this->metadata->get('site_name')->value, 'string'),
                'link' => array($_SERVER['SERVER_NAME'] . '/', 'string'),
                'plug' => array($this->metadata->get('site_plug')->value, 'string')
        );
        $response = array();
        foreach ($answer as $member => $value)
            $response[] = array(array($member => $value), 'struct');
        $response = array($response, 'struct');

        return $this->xmlrpc->send_response($response);
    }

    // Return our most recent post
    function latest($request = null) {
        // get the post
        $newest = $this->posts->recent(); // the last 3 posts
        $latest = $newest[0];   // the most recent post

        $answer = $this->prepare($latest);

        // wrap it for XML-RPC
        $response = array();
        foreach ($answer as $row)
            $response[] = array($row, 'struct');
        $response = array($response, 'struct');

        return $this->xmlrpc->send_response($response);
    }

    // Return a specific post
    function post($request = null) {
        if ($request == null) {
            $which = 2; // local testing assumption
        } else {
            $parameters = $request->output_parameters();
            $which = $parameters['0'];
        }

        // get the post
        $thepost = (array) $this->posts->get($which);

        // build our raw response. 
        $answer = $this->prepare($thepost);

        // wrap it for XML-RPC
        $response = array();
        foreach ($answer as $row)
            $response[] = array($row, 'struct');
        $response = array($response, 'struct');

        return $this->xmlrpc->send_response($response);
    }

    // Return all our posts
    function posts($request = null) {
        // get the posts
        $theposts = $this->posts->getAll_array();

        // build our raw response. 
        $answer = array();
        foreach ($theposts as $onepost){
            $part = $this->preparex($onepost);

            $answer[] = array($part, 'struct');
        }

        // wrap it for XML-RPC
        $response = array($answer, 'struct');

        return $this->xmlrpc->send_response($response);
    }
    
     // Package a blog post entry as an XML-RPC response
    function prepare($post) {
        // build our raw response, tailored to our blog post columns
        $answer = array(
            // our syndication id
            array('code' => $this->metadata->get('syndication_code')->value),
            // our post id
            array('id' => $post['postid']),
            // our post date
            array('datetime' => $post['created_at']),
            // a link to our post
            array('link' => $_SERVER['SERVER_NAME'] . '/blog/posts/' . $post['postid']),
            // blog post title
            array('title' => $post['title']),
            // slug for our post
            array('slug' => $post['slug']),
        );
        return $answer;
    }
    
    // Package a blog post entry as part of a multi-post an XML-RPC response
    function preparex($post)
	{
        // build our raw response, tailored to our blog post columns
        $answer = array(
            // our syndication id
            'code' => $this->metadata->get('syndication_code')->value,
            // our post id
            'id' => $post['postid'],
            // our post date
            'datetime' => $post['created_at'],
            // a link to our post
            'link' => $_SERVER['SERVER_NAME'] . '/view/post/' . $post['postid'],
            // blog post title
            'title' => $post['title'],
            // slug for our post
            'slug' => $post['slug'],
        );
        return $answer;
    }
}

