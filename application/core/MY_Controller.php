<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		JLP
 * @copyright           2010-2013, James L. Parry
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller {

    protected $data = array();      // parameters for view components
    protected $id;                  // identifier for our content

    /**
     * Constructor.
     * Establish view parameters & load common helpers
     */

    function __construct() {
        parent::__construct();
        $this->data = array();
        $this->data['title'] = '?';
        $this->errors = array();
        $this->data['pageTitle'] = '??';
    }

    /**
     * Render this page
     */
    function render() {
        $menu = $this->config->item('menu_choices');
        if($this->session->userdata('username')) {
            unset($menu['Login']);
            $menu['Logout'] = '/logout';
        }
        $this->data['menubar'] = $this->build_menu_bar($menu);
        $this->data['sidebar'] = $this->build_side_bar();
        $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);

        $this->data['caboose_styles'] = $this->caboose->styles();
        $this->data['caboose_scripts'] = $this->caboose->scripts();
        $this->data['caboose_trailings'] = $this->caboose->trailings();
        
        // finally, build the browser page!
        $this->data['data'] = &$this->data;
        $this->parser->parse('_template', $this->data);
    }

    /**
     * Build an unordered list of linked items, such as used for a menu bar.
     * @param mixed $choices Array of name=>link pairs
     */
    function build_menu_bar($choices) {
        $menudata = array();
        foreach ($choices as $name => $link)
            $menudata['menudata'][] = array('menulink' => $link, 'menuname' => $name);
        return $this->parser->parse('_menubar', $menudata, true);
    }

    
    function build_side_bar()
    {
        $result = '';
        $current_role = $this->session->userdata('role');

        if ($this->session->userdata('username')) {
            // show user name etc
            $side_data = $this->session->all_userdata();
            $side_data['secret_menu'] = '';
                if ($current_role == 'admin')
                    $side_data['secret_menu'] = $this->parser->parse('_admin_menu', $side_data, true);
            $result .= $this->parser->parse('_loggedin', $side_data, true);
        } else {
            // show the login form
            $result .= $this->load->view('_login', $this->data, true);
        }
        return $result;
    }
    
    function restrict($required_access = null)
    {
        if(!$required_access)
            return;

        else
        {
            $current_role = $this->session->userdata('role');

            if (is_array($required_access) && !in_array($current_role, $required_access)
                    || (!is_array($required_access) && $current_role != $required_access))
            {
                    redirect('/login');
                    return;
            }
        }
    }
}

/* End of file MY_Controller.php */
/* Location: application/core/MY_Controller.php */