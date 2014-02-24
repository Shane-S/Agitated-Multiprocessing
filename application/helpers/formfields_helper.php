<?php

if (!defined('APPPATH'))
    exit('No direct script access allowed');

/**
 * helpers/forms_helper.php
 *
 * Functions to help with form generation
 *
 * @author		JLP
 * @copyright           Copyright (c) 2010-2013, James L. Parry
 *                      Used by Galiano Island Chamber of Commerce, with permission
 *
 * Updated              v4.0.0: Port to CI2.0
 * Updated              v5.0: Reskin with bootstrap
 * ------------------------------------------------------------------------
 */

/**
 *  Construct a text input.
 * 
 * @param string $label Descriptive label for the control
 * @param string $name ID and name of the control; s/b the same as the RDB table column
 * @param mixed $value Initial value for the control
 * @param string $explain Help text for the control
 * @param int $maxlen Maximum length of the value, characters
 * @param int $size width in ems of the input control
 * @param boolean $disabled True if non-editable
 */
function makeTextField($label, $name, $type="text", $value='', $width_class = 100, $explain = "", $prepend = "", $append = "", $required = false, 
        $maxlen = 40, $placeholder = '', $disabled = false, $keep = TRUE) {
    $CI = &get_instance();
    
    if($prepend != "")
        $prepend = $CI->parser->parse('_fields/xpend', array('_xpend' => 'pre', 'text' => $prepend), $keep);
    if($append != "")
        $append = $CI->parser->parse('_fields/xpend', array('_xpend' => 'ap', 'text' => $append), $keep);

    $parms = array(
        'label' =>  makeLabel($name, $label, $required, $keep),
        'name' => $name,
        'value' => htmlentities($value, ENT_COMPAT, 'UTF-8'),
        'prepend' => $prepend,
        'append' => $append,
        'explain' => $explain,
        'maxlen' => $maxlen,
        'width' => $width_class,
        'placeholder' => $placeholder,
        'type' => $type,
        'disabled' => ($disabled ? 'disabled="disabled"' : '')
    );
    return $CI->parser->parse('_fields/textfield', $parms, $keep);
}

/**
 * Construct a form row to edit a combo box field.
 * 
 * @param string $label Descriptive label for the control
 * @param string $name ID and name of the control; s/b the same as the RDB table column
 * @param string $value Initial value for the control
 * @param mixed $options Array of key/value pairs for the combobox
 * @param string $explain Help text for the control
 * @param int $maxlen Maximum length of the value, characters
 * @param int $size width in ems of the input control
 * @param boolean $disabled True if non-editable
 */
function makeComboField($label, $name, $value, $options, $required = false, $explain = "", $width_class = 100, $maxlen = 40, $size = 25, $disabled = false, $keep = TRUE) {
    $CI = &get_instance();
    $parms = array(
        'label' => makeLabel($name, $label, $required, $keep),
        'name' => $name,
        'value' => htmlentities($value, ENT_COMPAT, 'UTF-8'),
        'description' => makeDescription($explain),
        'maxlen' => $maxlen,
        'width' => $width_class,
        'size' => $size,
        'options' => $options,
        'disabled' => ($disabled ? 'disabled="disabled"' : '')
    );
    return $CI->parser->parse('_fields/combofield', $parms, $keep);
}

/**
 * 
 * 
 * @param type $for
 * @param type $text
 * @param type $required
 * @param type $keep
 * @return type
 */
function makeLabel($for, $text, $required = false, $keep = TRUE)
{
    $CI = &get_instance();
    
    $parms = array(
        'for' => $for,
        'text' => $text,
        'required' => $required
    );
    return $CI->parser->parse('_fields/label', $parms, $keep);
}

/**
 * 
 * @param type $body
 * @param type $head
 * @param type $footer
 * @param type $caption
 * @param type $width
 * @param type $keep
 * @return type
 */
function makeTable($body, $head, $footer = null, $caption = null, $width = 100, $keep = TRUE)
{
    $CI = &get_instance();
    $parms = array(
        'head' => $head,
        'body' => $body,
        'footer' => $footer,
        'caption' => $caption,
        'width' => $width
    );
    return $CI->parser->parse('_fields/table', $parms, $keep);
}

/**
 * 
 * @param type $headers
 * @param type $keep
 * @return type
 */
function makeTableHead($headers, $keep = TRUE)
{
    $CI = &get_instance();
    $parms = array(
        'headers'=>$headers
    );
    return $CI->parser->parse('_fields/table_header', $parms, $keep);
}

/**
 * 
 * @param type $rows
 * @param type $keep
 */
function makeTableBody($rows, $keep = TRUE)
{
    $CI = &get_instance();
    $parms = array('rows' => $rows);

    return $CI->parser->parse('_fields/table_body', $parms, $keep);
}

/**
 * 
 * @param type $footer_content
 * @param type $keep
 * @return type
 */
function makeTableFooter($footer_content, $keep = TRUE)
{
    $CI = &get_instance();
    $parms = array('footer_cols' => $footer_content);

    return $CI->parser->parse('_fields/table_foot', $parms, $keep); 
}

/**
 * 
 * 
 * @param type $text
 * @return type
 */
function makeButton($text, $keep = TRUE)
{
    $CI = &get_instance();
    
    $parms = array('text' => $text );
    return $CI->parser->parse('_fields/button', $parms, $keep);
}

/**
 * 
 * @param type $text
 * @param type $css_extras
 * @param type $keep
 * @return type
 */
function makeSubmit($text, $css_extras = "", $keep = TRUE)
{
    $CI = &get_instance();
    
    $parms = array('value' => $text, 'css-extras' => $css_extras);
    return $CI->parser->parse('_fields/submit', $parms, $keep);
}

/**
 * Make a link button.
 * 
 * @param type $description
 * @return string
 */
function makeDescription($description)
{
    if($description == null || $description == "")
        return "";

    $CI = &get_instance();
    return $CI->parser->parse('_fields/description', $description, $keep);
}

/**
 * Make a link button.
 * 
 * @param string $label Label to appear on the button
 * @param string $href Href the button links to
 * @param string $title "Tooltip" text 
 * @param string $css_extras Extra CSS class information
 */
function makeLinkButton($label, $href, $title, $css_extras = "", $keep = TRUE) {
    $CI = &get_instance();
    $parms = array(
        'label' => $label,
        'href' => $href,
        'title' => $title,
        'css_extras' => $css_extras
    );
    return $CI->parser->parse('_fields/link', $parms, $keep);
}

/**
 * Make an icon button.
 * 
 * @param string $icon Name of icon
 * @param string $href Href the button links to
 * @param string $title "Tooltip" text 
 * @param string $css_extras Extra CSS class information
 */
function makeIconButton($icon, $href, $title, $css_extras = "", $keep = TRUE) {
    $CI = &get_instance();
    $parms = array(
        'icon' => $icon,
        'href' => $href,
        'title' => $title,
        'css_extras' => $css_extras
    );
    return $CI->parser->parse('_fields/ilink', $parms, $keep);
}

/**
 * Make a combo icon button.
 * 
 * @param string $icon Name of icon
 * @param string $href Href the button links to
 * @param string $title "Tooltip" text 
 * @param array $options array for dropdown links
 * @param string $css_extras Extra CSS class information
 */
function makeComboButton($icon, $href, $title, $options, $css_extras = "", $keep = TRUE) {
    $CI = &get_instance();
    $parms = array(
        'icon' => $icon,
        'href' => $href,
        'title' => $title,
        'options' => $options,
        'css_extras' => $css_extras
    );
    return $CI->parser->parse('_fields/combobutton', $parms, $keep);
}

/**
 * Make a submit button.
 * 
 * @param string $label Label to appear on the button
 * @param string $href Href the button links to
 * @param string $title "Tooltip" text 
 * @param string $css_extras Extra CSS class information
 */
function makeSubmitButton($label, $title, $css_extras = "", $keep = TRUE) {
    $CI = &get_instance();
    $parms = array(
        'label' => $label,
        'title' => $title,
        'css_extras' => $css_extras
    );
    return $CI->parser->parse('_fields/submit', $parms, $keep);
}

/**
 * Make a date selector. 
 * 
 * @param <type> $label
 * @param <type> $name
 * @param <type> $value
 * @param <type> $explain
 * @param <type> $size 
 */
function makeDateSelector($label, $name, $value, $explain = "", $size = 10, $disabled = false, $keep = TRUE) {
    $CI = &get_instance(); // handle to CodeIgniter instance
    $CI->caboose->needed('date', $name);
    $parms = array(
        'label' => $label,
        'name' => $name,
        'value' => $value,
        'explain' => $explain,
        'size' => $size,
        'disabled' => ($disabled ? 'disabled="disabled"' : '')
    );
    return $CI->parser->parse('_fields/date', $parms, $keep);
}

/**
 * Construct a form row to edit a large field.
 * 
 * @param <type> $label
 * @param <type> $name
 * @param <type> $value
 * @param <type> $explain
 * @param <type> $maxlen
 * @param <type> $size
 * @param <type> $rows 
 */
function makeTextArea($label, $name, $value, $explain = "", $maxlen = 40, $size = 25, $rows = 5, $disabled = false, $keep = TRUE) {
    $height = (int) (strlen($value) / 80) + 1;
    if ($rows < $height)
        $rows = $height;
    $CI = &get_instance();
    $parms = array(
        'label' => $label,
        'name' => $name,
        'value' => htmlentities($value, ENT_COMPAT, 'UTF-8'),
        'explain' => $explain,
        'maxlen' => $maxlen,
        'size' => $size,
        'rows' => $rows,
        'disabled' => ($disabled ? 'disabled="disabled"' : '')
    );
    return $CI->parser->parse('_fields/textarea', $parms, $keep);
}

/**
 * Construct a form row to hold a "real" editor for a large field.
 * 
 * @param <type> $label
 * @param <type> $name
 * @param <type> $value
 * @param <type> $explain
 * @param <type> $maxlen (ignored)
 * @param <type> $size (ignored)
 * @param <type> $rows  (ignored)
 */
function makeTextEditor($label, $name, $value, $explain = "", $maxlen = 40, $size = 25, $rows = 5, $disabled = false, $keep = TRUE) {
    $CI = &get_instance(); // handle to CodeIgniter instance
    $CI->caboose->needed('editor', $name);
    $height = (int) (strlen($value) / 80) + 1;
    if ($rows < $height)
        $rows = $height;
    $parms = array(
        'label' => $label,
        'name' => $name,
        'value' => htmlentities($value, ENT_COMPAT, 'UTF-8'),
        'explain' => $explain,
//        'maxlen' => $maxlen,
        'size' => $size,
        'rows' => $rows,
        'disabled' => ($disabled ? 'disabled="disabled"' : '')
    );
    return $CI->parser->parse('_fields/textarea', $parms, $keep);
}

/**
 * Construct a form row to select a file to upload.
 * 
 * @param <type> $label
 * @param <type> $name
 * @param <type> $explain
 */
function makeImageUploader($label, $name, $explain = "", $keep = TRUE) {
    $CI = &get_instance();
    $parms = array(
        'label' => $label,
        'name' => $name,
        'explain' => $explain
    );
    return $CI->parser->parse('_fields/image_upload', $parms, $keep);
}

/**
 * Construct a form row to edit a checkbox.
 * @param <type> $label
 * @param <type> $name
 * @param <type> $value
 * @param <type> $explain
 * @param <type> $disable 
 */
function makeOptionCheckbox($label, $name, $value, $explain = "", $disabled = false, $keep = TRUE) {
    $CI = &get_instance();
    $parms = array(
        'label' => $label,
        'name' => $name,
        'value' => $value,
        'checked' => ($value == 'Y') ? 'checked' : '',
        'explain' => ($explain <> "") ? $explain : $name,
        'disabled' => ($disabled ? 'disabled="disabled"' : '')
    );
    return $CI->parser->parse('_fields/checkbox', $parms, $keep);
}

/**
 * Construct a stand-alone form field for choosing something (options)
 * @param <type> $number
 * @param <type> $name
 * @param <type> $value
 * @param <type> $explain 
 */
function makeComboSelector($number, $name, $value, $explain = "", $disabled = false, $keep = TRUE) {
    $CI = &get_instance();
    $parms = array(
        'number' => $number,
        'name' => $name,
        'value' => $value,
        'checked' => ($value == 'Y') ? 'checked' : '',
        'explain' => ($explain <> "") ? htmlentities($explain) : htmlentities($name),
        'disabled' => ($disabled ? 'disabled="disabled"' : '')
    );
    return $CI->parser->parse('_fields/combo_selector', $parms, $keep);
}

/**
 * Construct a form row to edit a checkbox
 * @param <type> $label
 * @param <type> $name
 * @param <type> $value
 * @param <type> $explain 
 */
function makeCheckbox($label, $name, $value, $explain = "", $disabled = false, $keep = TRUE) {
    $CI = &get_instance();
    $parms = array(
        'label' => $label,
        'name' => $name,
        'value' => $value,
        'checked' => ($value == 'Y') ? 'checked' : '',
        'explain' => ($explain <> "") ? $explain : $name,
        'disabled' => ($disabled ? 'disabled="disabled"' : '')
    );
    return $CI->parser->parse('_fields/checkbox', $parms, $keep);
}

/**
 * Construct a form row to edit a radiobutton
 * @param <type> $label
 * @param <type> $name
 * @param <type> $value
 * @param <type> $explain 
 */
function makeRadioButton($label, $name, $value, $explain = "", $disabled = false, $keep = TRUE) {
    $CI = &get_instance();
    if($explain != "")
        $explain = $CI->parser->parse('_fields/description', $explain, $keep);
    $label = $CI->parser->parse('_fields/label', $label, $keep);
    
    $parms = array(
        'label' => $label,
        'name' => $name,
        'value' => $value,
        'checked' => ($value == 'Y') ? 'checked' : '',
        'explain' => $explain,
        'disabled' => ($disabled ? 'disabled="disabled"' : '')
    );
    return $CI->parser->parse('_fields/checkbox', $parms, $keep);
}

/**
 * Construct a form row to edit a radiobutton
 * @param <type> $label
 * @param <type> $name
 * @param <type> $value
 * @param <type> $explain 
 */
function makeRadioButtons($title, $parms, $name, $explain = "", $disabled = false, $keep = TRUE) {
    $CI = &get_instance();
    $parms = array(
        'title' => $title,
        'name' => $name,
        'explain' => ($explain <> "") ? $explain : $name,
        'disabled' => ($disabled ? 'disabled="disabled"' : '')
    );
    $choices = array();
    $first = true;
    foreach ($parms as $value => $label) {
        $row = array(
            'value' => $value,
            'checked' => ($first) ? 'checked' : '',
            'label' => $label
        );
        $choices[] = $row;
        $first = false;
    }
    $parms['options'] = $choices;
    return $CI->parser->parse('_fields/radio_buttons', $parms, $keep);
}


/* End of file */
