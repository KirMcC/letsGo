<?php
/**
@author muni
@copyright http:www.smarttutorials.net
 */

require_once 'messages.php';

//site specific configuration declartion
define( 'BASE_PATH', 'https://scm.ulster.ac.uk/~B00595739/');
define( 'DB_HOST', 'localhost' );
define( 'DB_USERNAME', 'B00595739');
define( 'DB_PASSWORD', '262nck9O');
define( 'DB_NAME', 'b00595739');

function __autoload($class)
{
	$parts = explode('_', $class);
	$path = implode(DIRECTORY_SEPARATOR,$parts);
	require_once $path . '.php';
}
