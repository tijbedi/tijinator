<?php
/**
* @author Kshitij Bedi
* @copyright zuova.com 03/2007
* @version 1.0
* @package configuration
* @desc Configuration file for the line file application
*
* 
* This is the main configuration file for the generic application framework.
* This file sets all configuration settings for the applicaton which includes :
* 
* 1) Turning the application on/off
* 2) MYSQL database connectivity 
* 3) MSSQL database connectivity
* 4) Contact email address for users of the application
* 5) Paths to application resources (the application itself, graphics, files in and out of the web root, etc.)
* 6) Administrators of the application
* 7) PHP.ini override settings
* 8) Error reporting
* In general think of this as the .ini file for the application
*/

/**
* For variable names and attributes do not use extended characters
* Format is $variable_name = value;
*/
define("CONFIG", TRUE);

/**
* APPLICATION_STATUS
* 0 = closed (user will be redirected to closed.php in the web root
* 1 = open
*/ 
define("APPLICATION_STATUS","0");
define("APPLICATION_SERVER","http://www.zuova.com/");
define("APPLICATION_LIVEPATH","http://www.zuova.com/");
define("APPLICATION_RESPONSE_PATH","http://www.zuova.com");
define("APPLICATION_PATH","/srv/www/applications/zuova");
define("APPLICATION_REAL_LIVEPATH","/srv/www/htdocs/zuova");
define("APPLICATION_NAME","www.zuova.com");

/**
* MYSQL connection parameters
*/
define("APPLICATION_DATABASE","zuova");
define("APPLICATION_DATABASE_HOST","nycserver1.govsip.com");
define("APPLICATION_DATABASE_USER","zuova_manager");
define("APPLICATION_DATABASE_PASSWORD","!lpbp!tcl0t");

/**
* MSSQL connection parameters
*/
define("APPLICATION_MSSQL_DATABASE_DSN","");
define("APPLICATION_MSSQL_DATABASE_USER","");
define("APPLICATION_MSSQL_DATABASE_PASSWORD","");

/**
* CONTACT EMAIL
*/
define("APPLICATION_CONTACT_EMAIL","info@zuova.com");
define("APPLICATION_ADMIN_EMAIL","zuova.com Administrator <admin@zuova.com>");

// LIMIT FOR PAGING RESULTS
define("APPLICATION_LIMIT","25");

/**
* Other useful constants
*/
define("PHP_SELF","?".$_SERVER['QUERY_STRING']);


/**
* List of pages that will be displayed without authentication
*/
define("NO_AUTH_LIST","");

/**
* Set locale for money format
*/
setlocale(LC_MONETARY, 'en_US');

/**
* PATHS
* Paths to web accessible and non accessible directories such as graphics, files, etc.
*
*/
define("APPLICATION_GRAPHICS_PATH","/graphics");

/**
* Application banner name which resides in <web root>/<APPLICATION_GRAPHICS_PATH>
*/
define("APPLICATION_BANNER","logo.gif");


/**
* APPLICATION_ADMINS 
* An array of PIDs of each user that is allowed admin privledges for this appliaction
*/
$APPLICATION_ADMINS = array('173','2');

/**
* Traffic (page request) tracking
* Please Note : An application table (i.e.webracking) should be in the  database
*               before this is enabled 
*/
define("APPLICATION_TRAFFIC_TRACKING","0");


/**
* PHP.INI SETTING
* Used to override the php.ini on the server with new settings.
* Please Note : Not all settings can be overridden using ini_set (see php.net for more details) 
*/ 
ini_set('output_buffering','0');

/**
* ERROR REPORTING LEVEL
*/ 
error_reporting(E_ALL ^ E_NOTICE);
//error_reporting(E_ALL);//this will report all undefined variables - which is a total pain

?>
