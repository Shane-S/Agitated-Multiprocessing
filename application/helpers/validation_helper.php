<?php

if (!defined('APPPATH'))
    exit('No direct script access allowed');
/**
 * helpers/validation_helper.php
 *
 * Useful functions to validate stuff
 *
 * @author              JLP
 * @copyright           Copyright (c) 2011-2013, JL Parry
 * 
  ­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­­
 */

/**
 * Validate an XML document against its DTD
 *
 * Example usage (inside a controller method):
 *  $this­>load­>helper('validation');
 *  $data['validation_results'] = validate_dtd(DATA_FOLDER . '/xml/pricing.xml');
 *  $this­>load­>view('whatever',$data);
 *
 * @param string $filename  Name of the file whose contents you want to display, relative to the document root
 * @return string   Either "Ok" or else an error message.
 */
function validate_dtd($filename) {
    $doc = new DOMDocument();   // make an empty DOM document
    
    libxml_use_internal_errors(true);
    $doc->load($filename);
    if ($doc->validate())
        return 'Ok';
    else {
        $result = "<b>Oh nooooo...</b><br/>";
        foreach (libxml_get_errors() as $error) {
            $result .= $error->message . '<br/>';
        }
        libxml_clear_errors();
        return $result;
    }
}