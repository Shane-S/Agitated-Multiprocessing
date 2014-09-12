<?php

if (!defined('APPPATH'))
    exit('No direct script access allowed');
/**
 * helpers/display_helper.php
 *
 * Useful functions to help display stuff
 *
 * @author              JLP
 * @copyright           Copyright (c) 2011-2013, JL Parry
 * 
  ­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­
 */

/**
 * Retrieve the contents of a file and prepare it for browser display.
 *
 * Example usage (inside a controller method):
 *  $this­>load­>helper('display');
 *  $data['contents'] = display_file('./data/flights.dtd');
 *  $this­>load­>view('whatever',$data);
 *
 * @param string $filename  Name of the file whose contents you want to display, relative to the document root
 * @return string   The appropriately encoded text string containing that file's contents.
 */
function display_file($filename) {
    $CI = & get_instance();      // get "our" object instance reference, because this is just a function
    $CI->load->helper('file');  // load the CI file helper
    $stuff = read_file($filename);    // retrieve the requested file content
    $stuff = htmlentities($stuff);  // convert any HTML entities
    $stuff = '<code><pre class="pre-scrollable">' . $stuff . '</pre></code>';  // bracket the result inside *code* and *pre* HTML elements
    return $stuff;  // whew!
}

/**
 * Perform an XSL transform on an XML document.
 *
 * @param string $filename  Name of the file whose contents you want to transform
 * @param string $xslname Name of the XSL stylesheet to use, if not the bound one
 * @return string   The HTML fragment resulting from the transformation.
 */
function xsl_transform($filename, $xslname = null) {
    // Get the original XML document
    $xml = new DOMDocument();
    $xml->load($filename);

    if ($xslname == null) {
        // extract bound stylesheet from embedded link
        $xp = new DOMXPath($xml);
        // use xpath to get the directive
        $pi = $xp->evaluate('/processing-instruction("xml-stylesheet")')->item(0);
        // extract the "data" part of it
        $data = $pi->data;
        // find out where the href starts
        $start = strpos($data, 'href=');
        // and extract the stylesheet name
        $xslname = XML_FOLDER . substr($data, $start + 6, -1);
    }
    // load the XSL stylesheet    
    $xsl = new DOMDocument();
    $xsl->load($xslname);
    // prime the transform engine
    $xslt = new XSLTProcessor();
    $xslt->importStyleSheet($xsl);
    // and away we go!
    return $xslt->transformToXml($xml);
}
