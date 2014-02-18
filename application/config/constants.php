<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

define('ENV_DEFAULT', 'default');
define('ENV_HOSTED', 'hosted');

define('ROOT_FOLDER', $_SERVER['DOCUMENT_ROOT']);    // folder documents are being dished from

if ($_SERVER['SERVER_NAME'] == 'agitated-multiprocessing.bcitxml.com')
    define('DB_ENV', ENV_HOSTED);
else 
    define('DB_ENV', ENV_DEFAULT);

// location of data folders
define('DATA_FOLDER', './data');
define('XML_FOLDER', DATA_FOLDER.'/xml/');

// user roles
define('ROLE_GUEST', 'guest');
define('ROLE_VISITOR','visitor');
define('ROLE_USER','user');
define('ROLE_ADMIN','admin');

// blog constants
define('POSTS_PER_PAGE', 6);
define('DATE_FORMAT', 'Y-m-d');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
// NOTE - these may already be defined in your environment, and may need commenting out
//define('FILE_READ_MODE', 0644);
//define('FILE_WRITE_MODE', 0666);
//define('DIR_READ_MODE', 0755);
//define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */
