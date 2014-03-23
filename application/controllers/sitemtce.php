<?php

class SiteMtce extends Application
{
    function __construct() {
        parent::__construct();
        $this->restrict(ROLE_ADMIN);
        $this->load->model('metadata');
        $this->load->library('xmlrpc');
    }
    
    function index()
    {
        $site_name_label = makeLabel('site_name', 'Site name:');
        $site_plug_label = makeLabel('site_plug', 'Plug:');
        $site_plug_explain = makeDescription('A concise sentence describing the site.');
        $site_code_label = makeLabel('syndication_code', 'Syndication code:');
        $site_code_explain = makeDescription('The unique 3-character syndication code for the site, e.g. \'o03\'.');
        
        $this->data['site_name'] = makeTextField($site_name_label,'site_name', 'text', $this->metadata->get('site_name')->value);
        $this->data['site_plug'] = makeTextField($site_plug_label,'site_plug', 'text', $this->metadata->get('site_plug')->value, 
                                   40, 128, $site_plug_explain);
        $this->data['syndication_code'] = makeTextField($site_code_label,'syndication_code', 'text', $this->metadata->get('syndication_code')->value, 
                                   40, 3, $site_code_explain);
        $this->data['pagebody'] = 'siteMtceView';
        $this->data['title'] = 'Site Maintenance';
        $this->render();
    }

    /**
     * Updates the database and sends the new information to the showcase.
     */
    function submit()
    {
        $info = array(
                'site_name'         => $this->metadata->get('site_name'),
                'site_plug'         => $this->metadata->get('site_plug'),
                'syndication_code'  => $this->metadata->get('syndication_code')
        );

        foreach($info as $property => $row)
        {
            if(!empty($_POST[$property]))
            {
                $row->value = $_POST[$property]; // Set the value associated with property "property" in the database
                $this->metadata->update($info[$property]);
            }
        }
        $this->update_remote_info(array('site_name'         => $info['site_name']->value, 
                                        'syndication_code'  => $info['syndication_code']->value,
                                        'site_plug'         => $info['site_plug']->value));
        redirect('/sitemtce');
    }
    
    private function update_remote_info($info)
    {
        $this->xmlrpc->server('http://showcase.bcitxml.com/boss', 80);
        $this->xmlrpc->method('update');
        $request = array(
            array($info['syndication_code'],     'string'),
            array($info['site_name'],            'string'),
            array($_SERVER['SERVER_NAME'] . '/', 'string'),
            array($info['site_plug'],            'string')
        );
        $this->xmlrpc->request($request);
        $this->xmlrpc->send_request($request);
    }
}
