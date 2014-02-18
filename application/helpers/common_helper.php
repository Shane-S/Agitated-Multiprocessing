<?php

if (!defined('APPPATH'))
    exit('No direct script access allowed');

/**
 * helpers/common_helper.php
 *
 * Functions extracted through refactoring
 *
 * @package		GICC Backend
 * @author		JLP
 * @copyright           Copyright (c) 2009-2013, Galiano Island Chamber of Commerce
 * @since		Version 3.15
 * Updated              v3.18.6: Added extractChanges method
 * Updated              v3.18.6: Switch text/html properties - we need text for mailouts,
 *                          html for all others
 * Updated              v4.0.0: Port to CI2.0
 * ------------------------------------------------------------------------
 */
//-------------------------------------------------------------------------
//  Object/array manipulation

/**
 * Extract cells from an array into corresponding properties in an object
 * @param array $source
 * @param object $target
 * @param array $fields 
 */
if (!function_exists('fieldExtract')) {

    function fieldExtract($source, $target, $fields) {
        foreach ($fields as $prop) {
            if (isset($source[$prop])) {
                $target->$prop = html_entity_decode($source[$prop]);
            }
        }
    }

}

/**
 * Inject cells into an array from corresponding properties in an object
 * @param <type> $source
 * @param <type> $target
 * @param <type> $fields 
 */
function fieldInject($source, &$target, $fields) {
    foreach ($fields as $prop) {
        if (isset($source->$prop)) {
//            $target[$prop] = html_entity_encode($source->$prop);
            $target[$prop] = $source->$prop;
        }
    }
}

/**
 * Identify any changed fields and build the body of an email message for membership@
 * @param <type> $source
 * @param <type> $target
 * @param <type> $fields
 * @param <type> $changes
 * @return string 
 */
function extractChanges($source, $target, $fields, $changes) {
    foreach ($fields as $prop) {
        if (isset($source[$prop])) {
            if ($source[$prop] != $target->$prop) {
                $changes[] = "Field: " . $prop;
                $changes[] = "Old value: " . $target->$prop;
                $changes[] = "New value: " . $source[$prop];
                $changes[] = "";
            }
        }
    }
    return $changes;
}

/**
 * Extract properties from an object
 * @param <type> $source
 * @param <type> $fields
 * @param <type> $changes
 * @return string 
 */
function extractFields($source, $fields, $changes) {
    foreach ($fields as $prop) {
        if (isset($source->$prop)) {
            $changes[] = $prop . ": ";
            $changes[] = $source->$prop;
        }
    }
    return $changes;
}

/**
 * Collapse an array of strings into a single string, with breaks
 * @param <type> $what
 * @return string 
 */
function collapseArray($what) {
    $result = "";
    foreach ($what as $one) {
        $result .= $one . "<br/>";
    }
    return $result;
}

/* End of file */
