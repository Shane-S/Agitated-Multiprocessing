<?php

/**
 * Checks a that a file's extension (and optionally file size) are within specified
 * constraints.
 * 
 * @param mixed $file               The file or URL to validate.
 * @param mixed $allowed_extensions Allowed file extensions.
 * @param int $maxsize              The maximum file size (in bytes; ignored for URLs).
 * @return array                    An array containing submission errors.
 */
function validate_file($file, $allowed_extensions, $maxsize = 512000)
{
    $errors = array();
    $extension = '';
    if(isarray($file)) // the user submitted a real file
    {
        $extension = end(explode(".", $file['name']));
        if($file['size'] > $maxsize)
            $errors[] = 'File is too large; max file size is ' . $maxsize . ', your file is ' . $file['size'];
    }
    else // it's a URL
    {
        $name = end(explode('/', $file));
        $extension = end(explode('.', $name));
    }
    
    if(is_array($allowed_extensions) && !in_array($extension, $allowed_extensions))
    {
        $allowed_string = '';
        foreach($allowed_extensions as $ext)
            $allowed_string .= ".$ext, ";
        $errors[] = 'Invalid file extension .' . $extension . '. Allowed extensions: ' . $allowed_string;
    }
    else if($extension != $allowed_extensions)
        $errors[] = 'Invalid file extension .' . $extension . ' The file must be of type .' . $allowed_extensions;
   
    return $errors;
}

/**
 * Validates a string.
 * 
 * Checks whether the string is the correct length and optionally if contains
 * characters it shouldn't.
 * 
 * @param string    $input              The input string to validate.
 * @param int       $maxlen             The maximum allowed length of the string.
 * @param string    $fieldname          The input field from which the string came.
 * @param string    $allowed_chars      A list of allowed characters.
 * @param string    $forbidden_chars    A list of forbidden characters (ignored if allowed characters are sepcified).
 * @return string
 */
function validate_string($input, $maxlen, $fieldname, $allowed_chars = '', $forbidden_chars ='')
{
    $errors = array();
    if($input == '')
        $errors[] = $fieldname . ' must contain a value.';
    if($maxlen && $input.length > $maxlen)
        $errors[] = $fieldname . ' may have a maximum of ' . $maxlen . ' characters (you have ' . $input.length . ').';

    if($allowed_chars != '')
    {
        foreach($input as $char)
        {
            if(!in_array($char, (array)$allowed_chars))
            {
                $errors[] = $fieldname . ' must contain only these characters: ' . $allowed_chars;
                break;
            }
        }
    }
    else if($forbidden_chars != '')
    {
        foreach($input as $char)
        {
            if(in_array($char, (array)$forbidden_chars))
            {
                $errors[] = $fieldname . ' may not contain these characters: ' . $forbidden_chars;
                break;
            }
        }
    }
    
    return $errors;
}

